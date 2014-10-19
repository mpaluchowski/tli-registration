<?php

namespace controllers;

class Login {

	function beforeroute($f3) {
		if (\models\AuthenticationDao::isLoggedIn()) {
			$f3->reroute('/admin');
		}
	}

	function login($f3) {
		echo \View::instance()->render('login/login.php');
	}

	function login_process($f3) {
		$authDao = new \models\AuthenticationDao();

		$admin = $authDao->authenticate(
			$f3->get('POST.email'),
			$f3->get('POST.password')
			);

		if (!$admin) {
			$f3->reroute('/admin/login');
		} else {
			$authDao->loginUser($admin);
			$f3->reroute('/admin');
		}
	}

}
