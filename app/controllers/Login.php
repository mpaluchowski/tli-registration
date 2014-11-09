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

		if (\models\FlashScope::has('email')) {
			$f3->set('email', \models\FlashScope::pop('email'));
		}

		echo \View::instance()->render('login/login.php');
	}

	function login_process($f3) {
		$authDao = new \models\AuthenticationDao();

		$admin = $authDao->authenticate(
			$f3->get('POST.email'),
			$f3->get('POST.password')
			);

		if (!$admin) {
			\models\MessageManager::addMessage(
				'danger',
				\F3::get('lang.SignInErrorUserUnknown')
			);
			\models\FlashScope::push(
				'email',
				$f3->get('POST.email')
				);
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
			// Error fetching info from Google
			\models\MessageManager::addMessage(
				'danger',
				\F3::get('lang.SignInErrorGoogleProcessing')
			);
			$f3->reroute('@admin_login');
		}

		try {
			$userIdentification = $authDao->getUserOauthIdentification($tokenResponse->id_token);
		} catch (Exception $e) {
			// Error decoding token from Google
			\models\MessageManager::addMessage(
				'danger',
				\F3::get('lang.SignInErrorGoogleProcessing')
			);
			$f3->reroute('@admin_login');
		}

		$admin = $authDao->authenticate($userIdentification->email);

		if (!$admin) {
			// Admin not found
			\models\MessageManager::addMessage(
				'danger',
				\F3::get('lang.SignInErrorUserUnknown')
			);
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
