<?php

namespace controllers;

class Main {

	function index($f3) {
		$dictionaryDao = new \models\DictionaryDao();

		$f3->set('clubs', $dictionaryDao->readAllClubs());

		echo \View::instance()->render('main/index.php');
	}

	function process_registration($f3) {
		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->parseRequestToForm($f3->get('POST'));

		$registrationId = $registrationDao->saveRegistrationForm($form);
	}

	function registration_review($f3, $args) {
		print_r($f3->unserialize(base64_decode($args['data'])));
	}

}
