<?php

namespace controllers;

class Registration {

	function form($f3) {
		if (\models\FlashScope::has('registration')) {
			// Coming in with validation errors
			$f3->set('registration', \models\FlashScope::pop('registration'));
		}

		$dictionaryDao = new \models\DictionaryDao();

		$f3->set('clubs', $dictionaryDao->readAllClubs());

		$priceCalculator = \models\PriceCalculatorFactory::newInstance();

		$f3->set('pricing', $priceCalculator->fetchPricing());

		$registrationDao = new \models\RegistrationDao();
		if ($registrationDao->isSeatingLimited()) {
			$f3->set('seatStats', $registrationDao->readSeatStatistics());
		}

		echo \View::instance()->render('registration/form.php');
	}

	function form_process($f3) {
		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->parseRequestToForm(
			$f3->clean($f3->get('POST')),
			\models\L11nManager::language()
			);

		if ($f3->get("form_validator")) {
			$validator = $f3->get("form_validator");
			$messages = $validator::validateOnSubmit($form);

			if (0 !== count($messages)) {
				// Messages found, redirect back to form and show errors
				$registration = [
					'messages' => $messages,
					'email' => $form->getEmail(),
					];
				foreach ($form->getFields() as $name => $value) {
					$registration[$name] = $value;
				}
				\models\FlashScope::push('registration', $registration);
				$f3->reroute('@registration_form');
			}
		}

		// Check if e-mail already registered
		$formCheck = $registrationDao->readRegistrationByEmail($form->getEmail());

		if (null !== $formCheck
				&& null === $formCheck->getDatePaid()) {
			$f3->reroute('@registration_payment_info(@email=' . $form->getEmail() . ')');
			die;
		}

		if ($f3->get("form_processor")) {
			$processor = $f3->get("form_processor");
			$processor::processOnSubmit($form);
		}

		if (!$registrationDao->saveRegistrationForm($form)) {
			$f3->error(500);
		}

		$f3->set('registrationReviewUrl', \helpers\View::getBaseUrl() . '/registration/review/' . $form->getHash());
		$f3->set('form', $form);

		// Send confirmation e-mail
		$mailer = new \models\Mailer();

		$mailer->sendEmail(
			$form->getEmail(),
			$f3->get('lang.EmailRegistrationConfirmationSubject', $form->getEmail()),
			\View::instance()->render('mail/registration_confirm.php')
			);

		\models\MessageManager::addMessage(
			'success',
			$f3->get('lang.RegistrationFormSavedMsg', $form->getEmail())
			);

		// Reroute to an overview of the registration
		$f3->reroute('@registration_review(@registrationHash=' . $form->getHash() . ')');
	}

	function review($f3, $args) {
		if (!\models\RegistrationDao::validateHash($args['registrationHash']))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationFormByHash($args['registrationHash']);

		if (!$form)
			$f3->error(404);

		$priceCalculator = \models\PriceCalculatorFactory::newInstance();

		$f3->set('form', $form);
		$f3->set('paymentSummary', $priceCalculator->calculateSummary(
			$form,
			true,
			$form->getDatePaid()
			));

		echo \View::instance()->render('registration/review.php');
	}

	function code_redeem($f3) {
		if (!\models\DiscountCodeDao::validateCode($f3->get('POST.discount-code'))
				|| !is_numeric($f3->get('POST.registrationId')))
			$f3->error(404);

		// See if we can find the Registration
		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationById($f3->get('POST.registrationId'));

		if (!$form)
			$f3->error(404);

		// Try finding the code
		$discountCodeDao = new \models\DiscountCodeDao();

		$code = $discountCodeDao->readDiscountCodeByCodeEmail(
			$f3->get('POST.discount-code'),
			$form->getEmail()
			);

		if (!$code) {
			// Code not found, inform user
			\models\MessageManager::addMessage(
				'danger',
				$f3->get('lang.DiscountCodeNotFoundMsg', $f3->get('POST.discount-code'))
				);
			$f3->reroute('@registration_review(@registrationHash=' . $form->getHash() . ')');
		}

		// Code found, connect code to registration and inform user
		$discountCodeDao->redeemCode($code->getId(), $form->getId());

		\models\MessageManager::addMessage(
			'success',
			$f3->get('lang.DiscountCodeRedeemedMsg', $code->getCode())
			);
		$f3->reroute('@registration_review(@registrationHash=' . $form->getHash() . ')');
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

	function get_total_price($f3) {
		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->parseRequestToForm(
			$f3->clean($f3->get('GET')),
			\models\L11nManager::language()
			);

		$priceCalculator = \models\PriceCalculatorFactory::newInstance();

		$prices = $priceCalculator->calculateSummary($form, false)['total'];

		foreach ($prices as $currency => $price) {
			$prices[$currency] = \helpers\CurrencyFormatter::moneyFormat($currency, $price);
		}

		echo json_encode($prices);
	}

	function resend_email($f3, $args) {
		if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationFormByEmail($args['email']);

		if (null === $form)
			$f3->error(404);

		$f3->set('registrationReviewUrl', \helpers\View::getBaseUrl() . '/registration/review/' . $form->getHash());
		$f3->set('form', $form);

		$mailer = new \models\Mailer();

		$result = $mailer->sendEmail(
			$args['email'],
			$f3->get('lang.EmailRegistrationConfirmationSubject', $args['email']),
			\View::instance()->render('mail/registration_confirm.php')
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
