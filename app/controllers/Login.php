<?php

namespace controllers;

class Login {

	function beforeroute($f3) {
		if (\models\AuthenticationDao::isLoggedIn()
				&& $f3->get('PATTERN') === $f3->get('ALIASES.admin_login')) {
			$f3->reroute('@admin_registrations_list');
		}
	}

	function login($f3) {
		$authDao = new \models\AuthenticationDao();
		$f3->set('oauthState', $authDao->getOauthStateToken());
		echo \View::instance()->render('login/login.php');
	}

	function login_process($f3) {
		$authDao = new \models\AuthenticationDao();

		$admin = $authDao->authenticate(
			$f3->get('POST.email'),
			$f3->get('POST.password')
			);

		if (!$admin) {
			$f3->reroute('@admin_login');
		} else {
			$authDao->loginUser($admin);
			$f3->reroute('@admin_registrations_list');
		}
	}

	function login_process_oauth2($f3) {
		$authDao = new \models\AuthenticationDao();

		if (!$authDao->verifyOauthStateToken($f3->get('GET.state'))
				|| !$f3->exists('GET.code')) {
			$f3->error(401);
		}

		$web = new \Web;
		$result = $web->request(
			'https://accounts.google.com/o/oauth2/token',
			[
				'method' => 'POST',
				'content' => http_build_query([
					'code' => $f3->get('GET.code'),
					'client_id' => $f3->get('google_client_id'),
					'client_secret' => $f3->get('google_client_secret'),
					'redirect_uri' => \helpers\View::getBaseUrl() . \F3::get('ALIASES.admin_login_process_oauth2'),
					'grant_type' => 'authorization_code',
					]),
			]
			);

		$body = json_decode($result['body']);

		if (property_exists($body, 'error')) {
			$f3->reroute('@admin_login');
		}

		$userIdentification = \JWT::decode($body->id_token, null, false);

		$admin = $authDao->authenticate($userIdentification->email);

		if (!$admin) {
			$f3->reroute('@admin_login');
		} else {
			$authDao->loginUser($admin);
			$f3->reroute('@admin_registrations_list');
		}
	}

	function logout($f3) {
		$authDao = new \models\AuthenticationDao();

		$authDao->logout();

		$f3->reroute('@admin_login');
	}

}
