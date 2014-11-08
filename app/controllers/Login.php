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
			// Invalid requests or CSRF attack
			$f3->error(401);
		}

		$tokenResponse = $authDao->getUserOauthToken(
			$f3->get('GET.code'),
			\helpers\View::getBaseUrl() . \F3::get('ALIASES.admin_login_process_oauth2')
			);

		if (property_exists($tokenResponse, 'error')) {
			$f3->reroute('@admin_login');
		}

		$userIdentification = $authDao->getUserOauthIdentification($tokenResponse->id_token);

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
