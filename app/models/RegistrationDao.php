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

		foreach ($postValues as $key => $value) {
			if (empty($value))
				continue;

			if (method_exists($form, 'set' . \F3::instance()->camelcase($key))) {
				$form->{'set' . \F3::instance()->camelcase($key)}(\F3::instance()->clean($value));
			} else {
				$form->setField($key, \F3::instance()->clean($value));
			}
		}

		return $form;
	}

	function saveRegistrationForm($form) {
		\F3::get('db')->begin();

		$query = 'INSERT INTO ' . \F3::get('db_table_prefix') . 'registration (
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

		\F3::get('db')->commit();

		return $registrationId;
	}

}
