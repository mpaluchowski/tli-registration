<?php

namespace controllers;

class Registration {

	function form($f3) {
		$dictionaryDao = new \models\DictionaryDao();

		$f3->set('clubs', $dictionaryDao->readAllClubs());

		echo \View::instance()->render('registration/index.php');
	}

	function form_process($f3) {
		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->parseRequestToForm($f3->clean($f3->get('POST')));

		// Check if e-mail already registered
		$formCheck = $registrationDao->readRegistrationByEmail($form->getEmail());

		if (null !== $formCheck
				&& null === $formCheck->getDatePaid()) {
			$f3->reroute('@registration_payment_info(@email=' . $form->getEmail() . ')');
			die;
		}

		// Check if a custom club name was entered
		if ($form->hasField('home-club-custom')
				&& $form->getField('home-club-custom')) {
			$dictionaryDao = new \models\DictionaryDao();
			$dictionaryDao->createClub($form->getField('home-club-custom'));

			$form->setField('home-club', $form->getField('home-club-custom'));
			$form->clearField('home-club-custom');
		}

		$registrationDao->saveRegistrationForm($form);

		// Send confirmation e-mail
		$mailer = new \models\Mailer();

		$mailer->sendEmail(
			$form->getEmail(),
			$f3->get('lang.EmailRegistrationConfirmationSubject', $form->getEmail()),
			$f3->get(
				'lang.EmailRegistrationConfirmationBody',
				[
					$form->getEmail(),
					\helpers\View::getBaseUrl() . '/registration/review/' . $form->getHash(),
				]
				)
			);

		$f3->reroute('@registration_review(@registrationHash=' . $form->getHash() . ')');
	}

	function review($f3, $args) {
		if (!is_string($args['registrationHash']) && 40 != strlen($args['registrationHash'] + 0))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationForm($args['registrationHash']);

		if (!$form)
			$f3->error(404);

		$f3->set('form', $form);

		echo \View::instance()->render('registration/review.php');
	}

	function info_proceed_to_payment($f3, $args) {
		if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationByEmail($args['email']);

		if (null === $form)
			$f3->error(404);

		$f3->set("email", $args['email']);

		echo \View::instance()->render('registration/info_proceed_to_payment.php');
	}

	function check_email_exists($f3, $args) {
		if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationByEmail($args['email']);

		if (null === $form)
			echo json_encode([]);
		else if (null === $form->getDatePaid()) {
			echo json_encode([
				"message" => $f3->get(
					'lang.EmailAlertRegisteredNoPayment',
					'/registration/info_proceed_to_payment/' . $args['email']
					)
				]);
		}
	}

	function resend_email($f3, $args) {
		if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationByEmail($args['email']);

		if (null === $form)
			$f3->error(404);

		$mailer = new \models\Mailer();

		$result = $mailer->sendEmail(
			$args['email'],
			$f3->get('lang.EmailRegistrationConfirmationSubject', $args['email']),
			$f3->get(
				'lang.EmailRegistrationConfirmationBody',
				[
					$args['email'],
					\helpers\View::getBaseUrl() . '/registration/review/' . $form->getHash(),
				]
				)
			);

		if ($result)
			$f3->reroute('@registration_email_confirm(@email=' . $args['email'] . ')');
		else
			$f3->reroute('@registration_email_failed(@email=' . $args['email'] . ')');
	}

	function resend_email_confirm($f3, $args) {
		if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL))
			$f3->error(404);

		$f3->set("email", $args['email']);

		echo \View::instance()->render('registration/resend_email_confirm.php');
	}

	function resend_email_failed($f3, $args) {
		if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL))
			$f3->error(404);

		$f3->set('email', $args['email']);

		echo \View::instance()->render('registration/resend_email_failed.php');
	}

}
