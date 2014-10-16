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

		$form = $registrationDao->parseRequestToForm($f3->clean($f3->get('POST')));

		$registrationId = $registrationDao->saveRegistrationForm($form);

		$f3->reroute('/review/' . $registrationId);
	}

	function registration_review($f3, $args) {
		if (!is_numeric($args['registrationId']) && !is_int($args['registrationId'] + 0))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationForm($args['registrationId']);

		$f3->set('form', $form);

		echo \View::instance()->render('main/review.php');
	}

}
