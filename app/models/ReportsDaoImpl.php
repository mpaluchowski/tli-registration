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

	function read($name) {
		return method_exists($this, \F3::instance()->camelcase('read_' . $name))
			? $this->{\F3::instance()->camelcase('read_' . $name)}()
			: null;
	}

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
				   AND rf_name.name IN ('full-name', 'exec-position')
				  JOIN tli_registration_fields rf_position
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
			$form->setStatusValue($row['status']);
			$form->setDatePaid($row['date_paid']);
			$form->setField('full-name', json_decode($row['full_name']));
			$form->setField('exec-position', json_decode($row['exec_position']));

			$data[$row['division']][$row['area']][$row['club_name']][json_decode($row['exec_position'])] = $form;
		}

		// Shift the 'other' clubs to the end of the array
		$temp = $data['other'];
		unset($data['other']);
		$data['other'] = $temp;

		return $data;
	}

}
