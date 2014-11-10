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

	/**
	 * @return boolean whether user is logged in currently.
	 */
	static function isLoggedIn() {
		return \F3::exists('SESSION.user');
	}

	/**
	 * @return user object stored in session.
	 */
	static function getUser() {
		return \F3::get('SESSION.user');
	}

	/**
	 * Stores user object in session for subsequent retrieval.
	 *
	 * @param user the user object to store.
	 */
	function loginUser($user) {
		\F3::set('SESSION.user', $user);
	}

	/**
	 * Deletes user's session, including the user object.
	 */
	function logout() {
		\F3::clear('SESSION');
	}

	/* Database authentication */

	/**
	 * Authenticate user against the database.
	 *
	 * @param email of user.
	 * @param password password supplied by user, if any. For OAuth-based
	 * authentications password can be left null, and code will only check if
	 * said user's email is in the database.
	 * @return user object, if email found in the database, and optionally when
	 * passwords match. Null otherwise.
	 */
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

		if (!$result
				|| ($password != null
					&& (!$result[0]['password']
						|| !password_verify($password, $result[0]['password'])
						)
					)
				) {
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

	/**
	 * Fetch user's OAuth ID Token from the provider.
	 *
	 * @param code the code received originally from the provider, allowing
	 * exchange for an ID token.
	 * @param redirectUrl the original URL used for redirecting to after passing
	 * through the provider.
	 * @return the body of the request for the token, returned from provider.
	 */
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

	/**
	 * Decode a user's OAuth identification information from a JWT-encoded ID
	 * token.
	 *
	 * @param idToken the token to decode.
	 * @return stdClass object with identification information.
	 */
	function getUserOauthIdentification($idToken) {
		return \JWT::decode($idToken, null, false);
	}

	/**
	 * Get an OAuth state token to send to a provider for later verification.
	 *
	 * @return random OAuth state token.
	 */
	function getOauthStateToken() {
		if (!\F3::exists('SESSION.oauthState')) {
			\F3::set('SESSION.oauthState', md5(rand()));
		}
		return \F3::get('SESSION.oauthState');
	}

	/**
	 * Verify that the OAuth state token matches what we have stored.
	 *
	 * @param token value to compare against the stored one.
	 * @return true when tokens match, false otherwise.
	 */
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
