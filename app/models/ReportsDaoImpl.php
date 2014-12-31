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

	/**
	 * Reads the list of people, who applied for lunch on any or all days of the
	 * conference.
	 *
	 * @return array with Registration Form instances of every person, who
	 * applied for lunch.
	 */
	function readLunchOrders() {
		$query = "
			SELECT rf_lunch.value AS lunch_days,
				   r.id_registration,
				   r.`status`,
				   r.email,
				   GROUP_CONCAT(IF(rf_info.name = 'full-name', rf_info.value, NULL)) AS full_name,
				   GROUP_CONCAT(IF(rf_info.name = 'phone', rf_info.value, NULL)) AS phone
			FROM " . \F3::get('db_table_prefix') . "registration_fields rf_lunch
			JOIN " . \F3::get('db_table_prefix') . "registrations r
			  ON rf_lunch.fk_registration = r.id_registration
			JOIN " . \F3::get('db_table_prefix') . "registration_fields rf_info
			  ON rf_lunch.fk_registration = rf_info.fk_registration
			 AND rf_info.name IN ('full-name', 'phone')
			WHERE rf_lunch.name = 'lunch-days'
			GROUP BY rf_lunch.fk_registration,
					 rf_lunch.name
			ORDER BY full_name";
		$result = \F3::get('db')->exec($query);

		$data = [];
		foreach ($result as $row) {
			$form = new \models\RegistrationForm();

			$form->setId($row['id_registration']);
			$form->setEmail($row['email']);
			$form->setStatus($row['status']);
			$form->setField('full-name', json_decode($row['full_name']));
			$form->setField('phone', json_decode($row['phone']));
			$form->setField('lunch-days', json_decode($row['lunch_days']));

			$data[] = $form;
		}
		return $data;
	}

	/**
	 * Read lists of people enrolled for all the events we're planning to
	 * organize.
	 *
	 * @return array indexed by event type with basic data on people, who asked
	 * to be included for specific events.
	 */
	function readEventEnrollments() {
		$query = "
			SELECT rf_events.name AS event_name,
				   rf_events.value AS event_value,
				   r.id_registration,
				   r.`status`,
				   r.email,
				   GROUP_CONCAT(IF(rf_info.name = 'full-name', rf_info.value, NULL)) AS full_name,
				   GROUP_CONCAT(IF(rf_info.name = 'phone', rf_info.value, NULL)) AS phone
			FROM " . \F3::get('db_table_prefix') . "registration_fields rf_events
			JOIN " . \F3::get('db_table_prefix') . "registrations r
			  ON rf_events.fk_registration = r.id_registration
			JOIN " . \F3::get('db_table_prefix') . "registration_fields rf_info
			  ON rf_events.fk_registration = rf_info.fk_registration
			 AND rf_info.name IN ('full-name', 'phone')
			WHERE rf_events.name IN (
				'friday-copernicus-options',
				'friday-social-event',
				'saturday-dinner-participate',
				'saturday-party-participate'
				)
			GROUP BY rf_events.fk_registration,
					 rf_events.name
			ORDER BY rf_events.name,
					 full_name";
		$result = \F3::get('db')->exec($query);

		$data = [];
		foreach ($result as $row) {
			$form = new \models\RegistrationForm();

			$form->setId($row['id_registration']);
			$form->setEmail($row['email']);
			$form->setStatus($row['status']);
			$form->setField('full-name', json_decode($row['full_name']));
			$form->setField('phone', json_decode($row['phone']));

			if ('friday-copernicus-options' == $row['event_name']) {
				foreach (json_decode($row['event_value']) as $option) {
					$data[$row['event_name'] . '-' . $option][] = $form;
				}
			} else {
				$data[$row['event_name']][] = $form;
			}
		}
		return $data;
	}

	/**
	 * Reads all registered officers, organized by position.
	 *
	 * @return array indexed by executive committee position with basic data on
	 * officers, who registered for each position.
	 */
	function readOfficersByPosition() {
		$query = "
			SELECT rf_positions.value AS exec_position,
				   r.id_registration,
				   r.`status`,
				   r.email,
				   GROUP_CONCAT(IF(rf_info.name = 'full-name', rf_info.value, NULL)) AS full_name,
				   GROUP_CONCAT(IF(rf_info.name = 'phone', rf_info.value, NULL)) AS phone,
				   GROUP_CONCAT(IF(rf_info.name = 'home-club', rf_info.value, NULL)) AS home_club
			FROM " . \F3::get('db_table_prefix') . "registration_fields rf_positions
			JOIN " . \F3::get('db_table_prefix') . "registrations r
			  ON rf_positions.fk_registration = r.id_registration
			JOIN " . \F3::get('db_table_prefix') . "registration_fields rf_info
			  ON rf_positions.fk_registration = rf_info.fk_registration
			 AND rf_info.name IN ('full-name', 'phone', 'home-club')
			WHERE rf_positions.name = 'exec-position'
			  AND rf_positions.value <> '\"none\"'
			GROUP BY rf_positions.fk_registration,
					 rf_positions.name
			ORDER BY rf_positions.value,
					 full_name";
		$result = \F3::get('db')->exec($query);

		$data = [];
		foreach ($result as $row) {
			$form = new \models\RegistrationForm();

			$form->setId($row['id_registration']);
			$form->setEmail($row['email']);
			$form->setStatus($row['status']);
			$form->setField('full-name', json_decode($row['full_name']));
			$form->setField('phone', json_decode($row['phone']));
			$form->setField('home-club', json_decode($row['home_club']));

			$data[json_decode($row['exec_position'])][] = $form;
		}
		return $data;
	}

	/**
	 * Reads comments posted during registration, ordered from earliest to
	 * latest.
	 *
	 * @return array of Registration Forms, which entered a comment, together
	 * with basic data about the person.
	 */
	function readLatestComments() {
		$query = "
			SELECT rf_comments.value AS comments,
				   r.id_registration,
				   r.`status`,
				   r.email,
				   GROUP_CONCAT(IF(rf_info.name = 'full-name', rf_info.value, NULL)) AS full_name,
				   GROUP_CONCAT(IF(rf_info.name = 'phone', rf_info.value, NULL)) AS phone,
				   GROUP_CONCAT(IF(rf_info.name = 'home-club', rf_info.value, NULL)) AS home_club
			FROM " . \F3::get('db_table_prefix') . "registration_fields rf_comments
			JOIN " . \F3::get('db_table_prefix') . "registrations r
			  ON rf_comments.fk_registration = r.id_registration
			JOIN " . \F3::get('db_table_prefix') . "registration_fields rf_info
			  ON rf_comments.fk_registration = rf_info.fk_registration
			 AND rf_info.name IN ('full-name', 'phone', 'home-club')
			WHERE rf_comments.name = 'comments'
			GROUP BY rf_comments.fk_registration,
					 rf_comments.name
			ORDER BY r.id_registration DESC";

		$result = \F3::get('db')->exec($query);

		$data = [];
		foreach ($result as $row) {
			$form = new \models\RegistrationForm();

			$form->setId($row['id_registration']);
			$form->setEmail($row['email']);
			$form->setStatus($row['status']);
			$form->setField('full-name', json_decode($row['full_name']));
			$form->setField('phone', json_decode($row['phone']));
			$form->setField('home-club', json_decode($row['home_club']));
			$form->setField('comments', json_decode($row['comments']));

			$data[] = $form;
		}
		return $data;
	}

	/**
	 * Read people who registered as duplicate officers roles in any club.
	 *
	 * @return array, indexed by club and position, with people, who registered
	 * as duplicate officers.
	 */
	function readOfficerDuplicates() {
		$query = "
			SELECT rf_club.value AS home_club,
				   rf_position.value AS exec_position,
				   r.id_registration,
				   r.`status`,
				   r.email,
				   GROUP_CONCAT(IF(rf_info.name = 'full-name', rf_info.value, NULL)) AS full_name,
				   GROUP_CONCAT(IF(rf_info.name = 'phone', rf_info.value, NULL)) AS phone
			FROM " . \F3::get('db_table_prefix') . "registration_fields rf_club
			JOIN " . \F3::get('db_table_prefix') . "registration_fields rf_position
			  ON rf_club.fk_registration = rf_position.fk_registration
			 AND rf_position.name = 'exec-position'
			 AND rf_club.name = 'home-club'
			JOIN " . \F3::get('db_table_prefix') . "registrations r
			  ON rf_club.fk_registration = r.id_registration
			JOIN " . \F3::get('db_table_prefix') . "registration_fields rf_info
			  ON rf_club.fk_registration = rf_info.fk_registration
			 AND rf_info.name IN ('full-name', 'phone')
			WHERE (rf_club.value, rf_position.value) IN (
				SELECT rf_clubs.value AS home_club,
					   rf_officers.value AS exec_position
				FROM " . \F3::get('db_table_prefix') . "registration_fields rf_clubs
				JOIN " . \F3::get('db_table_prefix') . "registration_fields rf_officers
				  ON rf_clubs.fk_registration = rf_officers.fk_registration
				 AND rf_officers.name = 'exec-position'
				 AND rf_officers.value <> '\"none\"'
				WHERE rf_clubs.name = 'home-club'
				GROUP BY rf_clubs.value,
						 rf_officers.value
				HAVING COUNT(rf_officers.value) > 1
			)
			GROUP BY rf_club.fk_registration
			ORDER BY home_club,
					 full_name";
		$result = \F3::get('db')->exec($query);

		$data = [];
		foreach ($result as $row) {
			$form = new \models\RegistrationForm();

			$form->setId($row['id_registration']);
			$form->setEmail($row['email']);
			$form->setStatus($row['status']);
			$form->setField('full-name', json_decode($row['full_name']));
			$form->setField('phone', json_decode($row['phone']));

			$data[json_decode($row['home_club'])][json_decode($row['exec_position'])][] = $form;
		}
		return $data;
	}

}
