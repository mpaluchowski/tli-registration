<?php

namespace models;

class RegistrationDao {

	public function __construct() {
		\F3::set('db', new \DB\SQL(
			'mysql:host=' . \F3::get('db_host') . ';port=' . \F3::get('db_port') . ';dbname=' . \F3::get('db_database'),
			\F3::get('db_username'),
			\F3::get('db_password'),
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
		));
	}

	function parseRequestToForm(array $postValues) {
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

		return $form;
	}

	function parseQueryToForm($registration, $registrationFields) {
		$form = new \models\RegistrationForm();

		$form->setId($registration['id_registration']);
		$form->setEmail($registration['email']);

		foreach ($registrationFields as $field) {
			$form->setField(
				$field['name'],
				json_decode($field['value'])
				);
		}

		return $form;
	}

	function saveRegistrationForm($form) {
		\F3::get('db')->begin();

		try {
			$query = 'INSERT INTO ' . \F3::get('db_table_prefix') . 'registrations (
						email,
						hash,
						date_entered
					)
					VALUES (
						:email,
						:hash,
						NOW()
						)';
			\F3::get('db')->exec($query, [
					'email' => $form->getEmail(),
					'hash' => $form->getHash(),
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
					'value' => json_encode($value),
					));
			}

			\F3::get('db')->commit();

		} catch (Exception $e) {
			\F3::get('db')->rollback();
		}

		return $registrationId;
	}

	function readRegistrationForm($registrationHash) {
		$query = 'SELECT r.id_registration,
						 r.email
				  FROM ' . \F3::get('db_table_prefix') . 'registrations r
				  WHERE r.hash = :registrationHash';
		$registrationResult = \F3::get('db')->exec($query, [
					'registrationHash' => $registrationHash,
				]);

		if (!$registrationResult)
			return null;

		$query = 'SELECT rf.name,
						 rf.value
				  FROM ' . \F3::get('db_table_prefix') . 'registration_fields rf
				  WHERE rf.fk_registration = :registrationId';

		$fieldsResult = \F3::get('db')->exec($query, [
					'registrationId' => $registrationResult[0]['id_registration'],
				]);

		return $this->parseQueryToForm($registrationResult[0], $fieldsResult);
	}

}
