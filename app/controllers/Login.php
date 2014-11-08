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
	}

	function logout($f3) {
		$authDao = new \models\AuthenticationDao();

		$authDao->logout();

		$f3->reroute('@admin_login');
	}

}
