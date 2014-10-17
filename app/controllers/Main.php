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

		$registrationDao->saveRegistrationForm($form);

		$f3->reroute('/review/' . $form->getHash());
	}

	function registration_review($f3, $args) {
		if (!is_string($args['registrationHash']) && 40 != strlen($args['registrationHash'] + 0))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationForm($args['registrationHash']);

		if (!$form)
			$f3->error(404);

		$f3->set('form', $form);

		echo \View::instance()->render('main/review.php');
	}

	function check_email_exists($f3, $args) {
		if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationByEmail($args['email']);

		if (null === $form->getDatePaid())
			echo $f3->get('lang.EmailAlertRegisteredNoPayment', '/registration/proceed_payment_info');
		else
			echo "false";
	}

}
