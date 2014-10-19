<?php

namespace models;

class AuthenticationDao {

	public function __construct() {
		\F3::set('db', new \DB\SQL(
			'mysql:host=' . \F3::get('db_host') . ';port=' . \F3::get('db_port') . ';dbname=' . \F3::get('db_database'),
			\F3::get('db_username'),
			\F3::get('db_password'),
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
		));
	}

	function authenticate($email, $password) {
		$query = 'SELECT a.id_administrator,
						 a.full_name,
						 a.email,
						 a.password
				  FROM ' . \F3::get('db_table_prefix') . 'administrators a
				  WHERE a.email = :email';
		$result = \F3::get('db')->exec($query, [
					'email' => $email,
				]);

		if (!$result || !password_verify($password, $result[0]['password'])) {
			return null;
		} else {
			return (object)[
				'id' => $result[0]['id_administrator'],
				'fullName' => $result[0]['full_name'],
				'email' => $result[0]['email'],
			];
		}
	}

	function loginUser($user) {
		\F3::set('SESSION.user', $user);
	}

	function logout() {
		\F3::clear('SESSION');
	}

	static function isLoggedIn() {
		return \F3::exists('SESSION.user');
	}

	static function getUser() {
		return \F3::get('SESSION.user');
	}

}
