<?php

namespace models;

class ReportsDaoImpl implements \models\ReportsDao {

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

	/**
	 * @see \models\ReportsDao#read($name)
	 */
	function read($name) {
		return method_exists($this, \F3::instance()->camelcase('read_' . $name))
			? $this->{\F3::instance()->camelcase('read_' . $name)}()
			: null;
	}

	/**
	 * Produce report data for officers registered, sorted by clubs. Clubs with
	 * no Division assigned, will be returned last.
	 *
	 * @return array, indexed by Division, Area, Club name and Executive
	 * Committee Position. Only clubs which have min. 1 officer registered,
	 * and only registered positions.
	 */
	function readOfficersByClub() {
		$query = "SELECT c.name AS club_name,
						 IFNULL(c.division, 'other') AS division,
						 IFNULL(c.area, 'other') AS area,
						 r.id_registration,
						 r.status,
						 r.date_paid,
						 rf_name.value AS full_name,
						 rf_position.value AS exec_position
				  FROM " . \F3::get('db_table_prefix') . "registrations r
				  JOIN " . \F3::get('db_table_prefix') . "registration_fields rf_club
				    ON r.id_registration = rf_club.fk_registration
				   AND rf_club.name = 'home-club'
				  JOIN " . \F3::get('db_table_prefix') . "registration_fields rf_name
				    ON r.id_registration = rf_name.fk_registration
				   AND rf_name.name = 'full-name'
				  JOIN " . \F3::get('db_table_prefix') . "registration_fields rf_position
				    ON r.id_registration = rf_position.fk_registration
				   AND rf_position.name = 'exec-position'
				   AND rf_position.value <> '\"none\"'
				  JOIN " . \F3::get('db_table_prefix') . "clubs c
				    ON rf_club.value = CONCAT('\"', c.name, '\"')
				  ORDER BY c.division,
				  		   c.area,
				  		   c.name";
		$result = \F3::get('db')->exec($query);

		$data = [];
		foreach ($result as $row) {
			$form = new \models\RegistrationForm();

			$form->setId($row['id_registration']);
			$form->setStatus($row['status']);
			$form->setDatePaid($row['date_paid']);
			$form->setField('full-name', json_decode($row['full_name']));
			$form->setField('exec-position', json_decode($row['exec_position']));

			$data[$row['division']][$row['area']][$row['club_name']][json_decode($row['exec_position'])] = $form;
		}

		if (isset($data['other'])) {
			// Shift the 'other' clubs to the end of the array
			$temp = $data['other'];
			unset($data['other']);
			$data['other'] = $temp;
		}

		return $data;
	}

	/**
	 * Produce data for report on people, who either offered accommodation for
	 * incoming Toastmasters, or asked to be accommodated with local
	 * Toastmasters.
	 *
	 * @return array indexed by accommodation status, with registrations for
	 * each of the types chosen.
	 */
	function readAccommodationWithToastmasters() {
		$query = "SELECT r.id_registration,
						 r.email,
						 r.`status`,
						 r.date_paid,
						 GROUP_CONCAT(IF(rf.name = 'accommodation-with-toastmasters', rf.value, NULL)) AS accommodation,
						 GROUP_CONCAT(IF(rf.name = 'accommodation-on', rf.value, NULL)) AS accommodation_on,
						 GROUP_CONCAT(IF(rf.name = 'full-name', rf.value, NULL)) AS full_name,
						 GROUP_CONCAT(IF(rf.name = 'phone', rf.value, NULL)) AS phone
				  FROM " . \F3::get('db_table_prefix') . "registrations r
				  JOIN " . \F3::get('db_table_prefix') . "registration_fields rf
					ON rf.fk_registration = r.id_registration
				   AND rf.name IN ('accommodation-with-toastmasters', 'accommodation-on', 'full-name', 'phone')
				  GROUP BY r.id_registration
				  HAVING accommodation IN ('\"host\"', '\"stay\"')
				  ORDER BY accommodation,
				  		   full_name";
		$result = \F3::get('db')->exec($query);

		$data = [];
		foreach ($result as $row) {
			$form = new \models\RegistrationForm();

			$form->setId($row['id_registration']);
			$form->setEmail($row['email']);
			$form->setStatus($row['status']);
			$form->setDatePaid($row['date_paid']);
			$form->setField('accommodation-with-toastmasters', json_decode($row['accommodation']));
			$form->setField('accommodation-on', json_decode($row['accommodation_on']));
			$form->setField('full-name', json_decode($row['full_name']));
			$form->setField('phone', json_decode($row['phone']));

			$data[json_decode($row['accommodation'])][] = $form;
		}
		return $data;
	}

}
