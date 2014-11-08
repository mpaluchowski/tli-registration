<?php

namespace models;

class AuthenticationDao {

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

	/* Basic login functions */

	static function isLoggedIn() {
		return \F3::exists('SESSION.user');
	}

	static function getUser() {
		return \F3::get('SESSION.user');
	}

	function loginUser($user) {
		\F3::set('SESSION.user', $user);
	}

	function logout() {
		\F3::clear('SESSION');
	}

	/* Database authentication */

	function authenticate($email, $password = null) {
		$query = 'SELECT a.id_administrator,
						 a.full_name,
						 a.email,
						 a.password
				  FROM ' . \F3::get('db_table_prefix') . 'administrators a
				  WHERE a.email = :email';
		$result = \F3::get('db')->exec($query, [
					'email' => $email,
				]);

		if (!$result || ($password != null && !password_verify($password, $result[0]['password']))) {
			return null;
		} else {
			return (object)[
				'id' => $result[0]['id_administrator'],
				'fullName' => $result[0]['full_name'],
				'email' => $result[0]['email'],
			];
		}
	}

	/* Google OAuth authentication */

	function getUserOauthToken($code, $redirectUrl) {
		$web = new \Web;
		$result = $web->request(
			'https://accounts.google.com/o/oauth2/token',
			[
				'method' => 'POST',
				'content' => http_build_query([
					'code' => $code,
					'client_id' => self::getGoogleClientId(),
					'client_secret' => $this->getGoogleClientSecret(),
					'redirect_uri' => $redirectUrl,
					'grant_type' => 'authorization_code',
					]),
				'follow_location' => false,
			]
			);

		return json_decode($result['body']);
	}

	function getUserOauthIdentification($idToken) {
		return \JWT::decode($idToken, null, false);
	}

	function getOauthStateToken() {
		if (!\F3::exists('SESSION.oauthState')) {
			\F3::set('SESSION.oauthState', md5(rand()));
		}
		return \F3::get('SESSION.oauthState');
	}

	function verifyOauthStateToken($token) {
		return \F3::exists('SESSION.oauthState')
				&& \F3::get('SESSION.oauthState') === $token;
	}

	static function getGoogleClientId() {
		if (!\F3::exists('google_client_id')
			|| !\F3::get('google_client_id')) {
			throw new \Exception('google_client_id variable must be configured.');
		}
		return \F3::get('google_client_id');
	}

	private function getGoogleClientSecret() {
		if (!\F3::exists('google_client_secret')
			|| !\F3::get('google_client_secret')) {
			throw new \Exception('google_client_secret variable must be configured.');
		}
		return \F3::get('google_client_secret');
	}

}
