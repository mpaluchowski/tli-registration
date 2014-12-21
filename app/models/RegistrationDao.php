<?php

namespace models;

class RegistrationDao {

	public function __construct() {
		if (!\F3::exists('db')) {
			\F3::set('db', new \DB\SQL(
				'mysql:host=' . \F3::get('db_host') . ';port=' . \F3::get('db_port') . ';dbname=' . \F3::get('db_database'),
				\F3::get('db_username'),
				\F3::get('db_password'),
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
			));
		}
	}

	function parseRequestToForm(array $postValues, $language) {
		$form = new \models\RegistrationForm();

		foreach ($postValues as $name => $value) {
			if (empty($value))
				continue;

			if (method_exists($form, 'set' . \F3::instance()->camelcase($name))) {
				$form->{'set' . \F3::instance()->camelcase($name)}(\F3::instance()->clean($value));
			} else {
				$form->setField($name, \F3::instance()->clean($value));
			}
		}

		$form->setLanguageEntered($language);

		return $form;
	}

	function parseQueryToForm($registration, $registrationFields = []) {
		$form = new \models\RegistrationForm();

		$form->setId($registration['id_registration']);
		$form->setEmail($registration['email']);
		$form->setLanguageEntered($registration['language_entered']);
		$form->setStatusValue($registration['status']);
		if (array_key_exists('date_entered', $registration))
			$form->setDateEntered($registration['date_entered']);
		if (array_key_exists('date_paid', $registration))
			$form->setDatePaid($registration['date_paid']);

		foreach ($registrationFields as $field) {
			$form->setField(
				$field['name'],
				json_decode($field['value'])
				);
		}

		return $form;
	}

	function parseQueryToFormArray($registration, $registrationFields) {
		$form = $registration;
		foreach ($registrationFields as $field) {
			$form[$field['name']] = json_decode($field['value']);
		}
		return $form;
	}

	function saveRegistrationForm(&$form) {
		$dateEntered = time();

		\F3::get('db')->begin();

		try {
			if ($this->isSeatingLimited()
					&& !$form->getStatusValue()
					&& $this->readSeatStatistics()->left == 0) {
				$form->setStatusValue('waiting-list');
			}

			$query = 'INSERT INTO ' . \F3::get('db_table_prefix') . 'registrations (
						email,
						hash,
						language_entered,
						status,
						date_entered
					)
					VALUES (
						:email,
						:hash,
						:languageEntered,
						:status,
						FROM_UNIXTIME(:dateEntered)
						)';
			\F3::get('db')->exec($query, [
					'email' => $form->getEmail(),
					'hash' => $form->getHash(),
					'languageEntered' => $form->getLanguageEntered(),
					'status' => $form->getStatusValue(),
					'dateEntered' => $dateEntered,
				]);

			$registrationId = \F3::get('db')->lastInsertID();

			$query = 'INSERT INTO ' . \F3::get('db_table_prefix') . 'registration_fields (
						fk_registration,
						name,
						value
						)
					VALUES (
						:registrationId,
						:name,
						:value
						)';
			$st = \F3::get('db')->prepare($query);

			foreach ($form->getFields() as $name => $value) {
				$st->execute(array(
					'registrationId' => $registrationId,
					'name' => $name,
					'value' => json_encode($value, JSON_UNESCAPED_UNICODE),
					));
			}

			\F3::get('db')->commit();

		} catch (Exception $e) {
			\F3::get('db')->rollback();
			return null;
		}

		$form->setId($registrationId);
		$form->setDateEntered(date('Y-m-d H:i:s', $dateEntered));

		return $registrationId;
	}

	/**
	 * Updates Registration's status to PAID, including timestamp.
	 *
	 * @param registrationId ID of registration.
	 * @param time unix time of when payment was completed.
	 */
	function updateRegistrationStatusToPaid($registrationId, $time = null) {
		if (!$time) $time = time();

		$query = 'UPDATE ' . \F3::get('db_table_prefix') . 'registrations
				  SET date_paid = FROM_UNIXTIME(:datePaid),
					  status = NULL
				  WHERE id_registration = :registrationId';
		\F3::get('db')->exec($query, [
				'datePaid' => $time,
				'registrationId' => $registrationId,
			]);
	}

	/**
	 * Updates Registration's status to PROCESSING_PAYMENT.
	 *
	 * @param registrationId ID of the Registration
	 */
	function updateRegistrationStatusToProcessingPayment($registrationId, $force = false) {
		$query = 'UPDATE ' . \F3::get('db_table_prefix') . 'registrations
				  SET status = "processing-payment"
				  WHERE id_registration = :registrationId';
		if (!$force)
			$query .= ' AND date_paid IS NOT NULL';
		\F3::get('db')->exec($query, [
				'registrationId' => $registrationId,
			]);
	}

	function readRegistrationFormByHash($registrationHash) {
		$query = 'SELECT r.id_registration,
						 r.email,
						 r.language_entered,
						 r.status,
						 r.date_entered,
						 r.date_paid
				  FROM ' . \F3::get('db_table_prefix') . 'registrations r
				  WHERE r.hash = :registrationHash';
		$registrationResult = \F3::get('db')->exec($query, [
					'registrationHash' => $registrationHash,
				]);

		if (!$registrationResult)
			return null;

		return $this->parseQueryToForm(
			$registrationResult[0],
			$this->fetchRegistrationFields($registrationResult[0]['id_registration'])
			);
	}

	/**
	 * Read a Registration, sans fields, by ID.
	 *
	 * @param $id the ID of the Registration
	 * @return instance of RegistrationForm or null if ID not found
	 */
	function readRegistrationById($id) {
		$result = $this->fetchRegistrationById($id);

		return $result
			? $this->parseQueryToForm($result[0])
			: null;
	}

	/**
	 * Read a Registration by ID, including all fields.
	 *
	 * @param $id the ID of the Registration
	 * @return instance of RegistrationForm or null if ID not found
	 */
	function readRegistrationFormById($id) {
		$registrationResult = $this->fetchRegistrationById($id);

		if (!$registrationResult)
			return null;

		return $this->parseQueryToForm(
			$registrationResult[0],
			$this->fetchRegistrationFields($registrationResult[0]['id_registration'])
			);
	}

	private function fetchRegistrationById($id) {
		$query = 'SELECT r.id_registration,
						 r.email,
						 r.language_entered,
						 r.status,
						 r.date_entered,
						 r.date_paid
				  FROM ' . \F3::get('db_table_prefix') . 'registrations r
				  WHERE r.id_registration = :id';
		return \F3::get('db')->exec($query, [
					'id' => $id,
				]);
	}

	function readRegistrationByEmail($email) {
		$result = $this->fetchRegistrationByEmail($email);

		return !$result
				? null
				: $this->parseQueryToForm($result[0]);
	}

	function readRegistrationFormByEmail($email) {
		$registrationResult = $this->fetchRegistrationByEmail($email);

		if (!$registrationResult)
			return null;

		return $this->parseQueryToForm(
			$registrationResult[0],
			$this->fetchRegistrationFields($registrationResult[0]['id_registration'])
			);
	}

	private function fetchRegistrationByEmail($email) {
		$query = 'SELECT r.id_registration,
						 r.email,
						 r.language_entered,
						 r.status,
						 r.date_entered,
						 r.date_paid
				  FROM ' . \F3::get('db_table_prefix') . 'registrations r
				  WHERE r.email = :email';
		return \F3::get('db')->exec($query, [
					'email' => $email,
				]);
	}

	private function fetchRegistrationFields($registrationId) {
		$query = 'SELECT rf.name,
						 rf.value
				  FROM ' . \F3::get('db_table_prefix') . 'registration_fields rf
				  WHERE rf.fk_registration = :registrationId';

		return \F3::get('db')->exec($query, [
					'registrationId' => $registrationId,
				]);
	}

	function readRegistrationStatistics() {
		$query = 'SELECT COUNT(r.id_registration) AS counted,
						 SUM(r.status IS NULL) AS registered,
						 SUM(r.status = "waiting-list") AS waiting_list,
						 SUM(r.status = "pending-review") AS pending_review,
						 SUM(r.status IS NULL AND r.date_paid IS NULL) AS pending_payment,
						 COUNT(r.date_paid) AS paid,
						 MAX(r.date_entered) AS last
				  FROM ' . \F3::get('db_table_prefix') . 'registrations r';
		$result = \F3::get('db')->exec($query);

		$leftCount = $this->getSeatLimit() - $result[0]['paid'];
		return (object)[
			'count' => $result[0]['counted'],
			'registered' => $result[0]['registered'] ? $result[0]['registered'] : 0,
			'waitingList' => $result[0]['waiting_list'] ? $result[0]['waiting_list'] : 0,
			'pendingReview' => $result[0]['pending_review'] ? $result[0]['pending_review'] : 0,
			'pendingPayment' => $result[0]['pending_payment'] ? $result[0]['pending_payment'] : 0,
			'paid' => $result[0]['paid'],
			'left' => $leftCount < 0 ? 0 : $leftCount,
			'last' => $result[0]['last'],
		];
	}

	function readRegistrationsByWeekStatistics() {
		$query = 'SELECT entered.year,
						 entered.week,
						 entered.entered,
						 paid.paid
				  FROM (
					SELECT YEAR(r.date_entered) AS year,
						   WEEK(r.date_entered, 3) AS week,
						   COUNT(r.id_registration) AS entered
					FROM ' . \F3::get('db_table_prefix') . 'registrations r
					GROUP BY YEARWEEK(r.date_entered, 3)
					) entered
				  LEFT JOIN (
				  	SELECT YEAR(r.date_paid) AS year,
						   WEEK(r.date_paid, 3) AS week,
						   COUNT(r.id_registration) AS paid
					FROM ' . \F3::get('db_table_prefix') . 'registrations r
					WHERE r.date_paid IS NOT NULL
					GROUP BY YEARWEEK(r.date_paid, 3)
				  	) paid
				  ON entered.year = paid.year
				  AND entered.week = paid.week
				  UNION ALL
				  SELECT YEAR(r.date_paid) AS year,
						 WEEK(r.date_paid, 3) AS week,
						 NULL AS enetered,
						 COUNT(r.id_registration) AS paid
				  FROM ' . \F3::get('db_table_prefix') . 'registrations r
				  GROUP BY YEARWEEK(r.date_paid, 3)
				  HAVING CONCAT(year, week) NOT IN (
				  	SELECT YEARWEEK(r.date_entered, 3) AS yeaweek
				  	FROM ' . \F3::get('db_table_prefix') . 'registrations r
				  	GROUP BY YEARWEEK(r.date_entered, 3)
				  	)
				  ORDER BY year,
				  		   week
				  ';
		$result = \F3::get('db')->exec($query);

		$weeks = [];
		foreach ($result as $row) {
			$weeks[] = (object)[
				'year' => $row['year'],
				'week' => $row['week'],
				'entered' => $row['entered'] ? $row['entered'] : 0,
				'paid' => $row['paid'] ? $row['paid'] : 0,
			];
		}
		return $weeks;
	}

	/**
	 * Count how many registrations are per status and how many seats are left.
	 *
	 * @return stdClass object with numbers of seats accordingly, or null, if
	 * seats are not limited.
	 */
	function readSeatStatistics() {
		if (!$this->isSeatingLimited()) {
			return null;
		}

		$query = 'SELECT SUM(r.status = "waiting-list") AS waiting_list,
						 SUM(r.status = "pending-review") AS pending_review,
						 SUM(r.status IS NULL AND r.date_paid IS NULL) AS pending_payment,
						 SUM(r.date_paid IS NOT NULL) AS paid
				  FROM ' . \F3::get('db_table_prefix') . 'registrations r';
		$result = \F3::get('db')->exec($query);

		$leftCount = $this->getSeatLimit() - $result[0]['paid'];
		return (object)[
			'pendingPayment' => $result[0]['pending_payment'] ? $result[0]['pending_payment'] : 0,
			'waitingList' => $result[0]['waiting_list'] ? $result[0]['waiting_list'] : 0,
			'pendingReview' => $result[0]['pending_review'] ? $result[0]['pending_review'] : 0,
			'left' => $leftCount < 0 ? 0 : $leftCount,
		];
	}

	/**
	 * Checks if seating is limited for this event.
	 *
	 * @return true if seating is limited. False otherwise.
	 */
	static function isSeatingLimited() {
		return (bool)\F3::get('registrations_limit_soft');
	}

	/**
	 * Returns the current seat limit, if seating is limited.
	 *
	 * @return Number of seats in the limit, or null if seats unlimited.
	 */
	static function getSeatLimit() {
		return self::isSeatingLimited()
			? \F3::get('registrations_limit_soft')
			: null;
	}

	function readAllRegistrationForms(array $selectFields = null, $toArray = false) {
		$query = 'SELECT r.id_registration,
						 r.email,
						 r.language_entered,
						 r.status,
						 r.date_entered,
						 r.date_paid
				  FROM ' . \F3::get('db_table_prefix') . 'registrations r
				  ORDER BY r.id_registration';
		$resultRegistrations = \F3::get('db')->exec($query);

		if (!$resultRegistrations)
			return [];

		$query = 'SELECT rf.fk_registration,
						 rf.name,
						 rf.value
				  FROM ' . \F3::get('db_table_prefix') . 'registration_fields rf';
		if ($selectFields) {
			$query .= ' WHERE rf.name IN (' . implode(',',
				array_map(function($value) {
						return \F3::get('db')->quote($value);
					}, $selectFields)
				) . ')';
		}
		$query .= ' ORDER BY rf.fk_registration';
		$resultFields = \F3::get('db')->exec($query);

		$registrations = [];
		$currentIndex = 0;
		foreach ($resultRegistrations as $registration) {
			$fields = [];

			while ($currentIndex != count($resultFields)
				&& $resultFields[$currentIndex]['fk_registration']
					== $registration['id_registration']) {
				$fields[] = $resultFields[$currentIndex];
				$currentIndex++;
			}

			$registrations[] = $toArray
				? $this->parseQueryToFormArray(
					$registration,
					$fields
					)
				: $this->parseQueryToForm(
					$registration,
					$fields
					);
		}

		return $registrations;
	}

	function readAllRegistrationFieldNames() {
		$query = 'SELECT DISTINCT rf.name
				  FROM ' . \F3::get('db_table_prefix') . 'registration_fields rf
				  ORDER BY rf.name';
		$result = \F3::get('db')->exec($query);

		$fieldNames = [];
		foreach ($result as $row) {
			$fieldNames[] = $row['name'];
		}
		return $fieldNames;
	}

}
