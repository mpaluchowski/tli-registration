<?php

namespace controllers;

class Administration {

	function beforeroute($f3) {
		if (!\models\AuthenticationDao::isLoggedIn()) {
			$f3->reroute('@admin_login');
		}
		$f3->set('user', \models\AuthenticationDao::getUser());
	}

	function list_registrations($f3) {
		$registrationDao = new \models\RegistrationDao();

		$renderer = \helpers\FormRendererFactory::className();

		$registrations = $registrationDao->readAllRegistrationForms($renderer::getMainFields());
		usort($registrations, "\helpers\Sorters::sortRegistrationsByFullName");

		$f3->set('stats', $registrationDao->readRegistrationStatistics());
		$f3->set('fieldColumns', $registrationDao->readAllRegistrationFieldNames());
		$f3->set('registrations', $registrations);

		echo \View::instance()->render('administration/list_registrations.php');
	}

	function get_registration_details($f3) {
		if (!$f3->get('GET.id')
			|| !is_numeric($f3->get('GET.id'))) {
			$f3->error(404);
		}

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationFormById($f3->get('GET.id'));

		if (null === $form)
			$f3->error(404);

		$f3->set('form', $form);

		echo \View::instance()->render('administration/_registration-details.php');
	}

	function status_change($f3) {
		if (!$f3->get('POST.id')
			|| !is_numeric($f3->get('POST.id'))) {
			$f3->error(404);
		}

		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationFormById($f3->get('POST.id'));

		if (null === $form)
			$f3->error(404);

		if ($f3->get('POST.status') === $form->getStatus()) {
			// Check if registration not already in chosen status
			\models\MessageManager::addMessage(
				'warning',
				$f3->get('lang.StatusChangedAlreadySetMsg', [
						$f3->get('lang.RegistrationStatus-' . $form->getStatus()),
					])
				);
		} else {
			$oldStatus = $form->getStatus();

			// Update status to desired value
			$registrationDao->updateRegistrationStatus($form, $f3->get('POST.status'));

			// Save Audit Log event
			$eventDao = new \models\EventDao();
			$eventDao->saveEvent(
				"RegistrationStatusChange",
				$f3->get('user')->id,
				[
					"old" => $oldStatus,
					"new" => $form->getStatus(),
				],
				'Registration',
				$form->getId()
				);

			$msg = 'StatusChangedSuccessMsg';

			if ('on' === $f3->get('POST.email')) {
				// Send notification e-mail
				$mailer = new \models\Mailer();

				$f3->set('registrationReviewUrl', \helpers\View::getBaseUrl() . '/registration/review/' . $form->getHash());
				$f3->set('form', $form);

				$originalLanguage = \models\L11nManager::language();
				\models\L11nManager::setLanguage($form->getLanguageEntered());

				$mailer->sendEmail(
					$form->getEmail(),
					$f3->get('lang.EmailRegistrationConfirmationSubject', $form->getEmail()),
					\View::instance()->render('mail/registration_confirm.php')
					);

				\models\L11nManager::setLanguage($originalLanguage);

				$msg = 'StatusChangedEmailedSuccessMsg';
			}

			\models\MessageManager::addMessage(
				'success',
				$f3->get('lang.' . $msg, [
						$f3->get('lang.RegistrationStatus-' . $form->getStatus()),
					])
				);
		}

		if ($f3->get('AJAX')) {
			echo json_encode([
				'status' => $form->getStatus(),
				'msg' => \View::instance()->render('message-alerts.php'),
				'label' => [
					'class' => \helpers\View::getRegistrationStatusLabel($form->getStatus()),
					'text' => \F3::get('lang.RegistrationStatus-' . $form->getStatus()),
				]
				]);
		} else {
			$f3->reroute('@admin_registrations_list');
		}
	}

	function codes($f3) {
		if (\models\FlashScope::has('discountCode')) {
			// Comin in with validation errors
			$f3->mset(\models\FlashScope::pop('discountCode'));
		}

		$priceCalculator = \models\PriceCalculatorFactory::newInstance();

		$f3->set('pricingItems', $priceCalculator->fetchPricing());

		$discountCodeDao = new \models\DiscountCodeDao();

		$f3->set('discountCodes', $discountCodeDao->readAllDiscountCodes());

		echo \View::instance()->render('administration/codes.php');
	}

	function code_create($f3) {
		$discountCodeDao = new \models\DiscountCodeDao();

		$code = $discountCodeDao->parseRequestToCode($f3->get('POST'));

		// Check if registration for this email not already paid
		$registrationDao = new \models\RegistrationDao();

		$form = $registrationDao->readRegistrationByEmail($code->getEmail());

		if ($form && ('paid' == $form->getStatus()
				|| 'cancelled' == $form->getStatus()
				)) {
			\models\MessageManager::addMessage(
				'danger',
				$f3->get('lang.CodesRegistrationEmailMsg-' . $form->getStatus(), [
						$code->getEmail(),
						\helpers\View::formatDateTime($form->getDatePaid())
					])
				);
			$f3->reroute('@admin_codes');
		}

		$messages = $discountCodeDao->validateDiscountCode($code);

		if (0 !== count($messages)) {
			// Validation returned messages, redirect back to form and show errors
			\models\FlashScope::push('discountCode', [
				"code" => $code,
				"messages" => $messages,
				"sendEmail" => $f3->exists('POST.send-email'),
				"sendEmailLanguage" => $f3->get('POST.send-email-language'),
				]);
			$f3->reroute('@admin_codes');
		}

		// Save the discount code
		$codeId = $discountCodeDao->saveDiscountCode($code);

		// Save Audit Log event
		$eventDao = new \models\EventDao();
		$eventDao->saveEvent(
			"DiscountCodeGenerate",
			$f3->get('user')->id,
			["email" => $code->getEmail()],
			'DiscountCode',
			$codeId
			);

		$messageType = 'success';

		if ($f3->get('POST.send-email')) {
			// Email code to the recipient, as requested
			$priceCalculator = \models\PriceCalculatorFactory::newInstance();
			$f3->set('pricingItems', $priceCalculator->fetchPricing());
			$f3->set('code', $code);

			$originalLanguage = \models\L11nManager::language();
			\models\L11nManager::setLanguage($f3->get('POST.send-email-language'));

			$mailer = new \models\Mailer();
			$mailResult = $mailer->sendEmail(
				$code->getEmail(),
				$f3->get('lang.EmailDiscountCodeSubject', $code->getEmail()),
				\View::instance()->render('mail/discount_code.php')
			);

			\models\L11nManager::setLanguage($originalLanguage);

			$messageKey = $mailResult
				? 'CodesCreatedEmailedMsg'
				: 'CodesCreatedNotEmailedMsg';
			if (!$mailResult)
				$messageType = 'warning';
		} else {
			$messageKey = 'CodesCreatedMsg';
		}

		// Setup confirmation message and redirect back to list
		\models\MessageManager::addMessage(
			$messageType,
			$f3->get('lang.' . $messageKey, $code->getEmail())
			);

		$f3->reroute('@admin_codes');
	}

	function statistics($f3) {
		$registrationDao = new \models\RegistrationDao();
		$statisticsDao = \models\StatisticsDaoFactory::newInstance();

		$f3->set('stats', $statisticsDao->readStatistics());
		$f3->set(
			'stats.registrations-by-status',
			$registrationDao->readRegistrationStatistics()
			);
		$f3->set(
			'stats.registrations-by-week',
			$registrationDao->readRegistrationsByWeekStatistics()
			);

		echo \View::instance()->render('administration/statistics.php');
	}

	function report($f3, $args) {
		$reportsDao = \models\ReportsDaoFactory::newInstance();

		$reportData = $reportsDao->read($args['reportName']);

		if (null === $reportData)
			$f3->error(404);

		$f3->set('data', $reportData);

		echo \View::instance()->render('administration/report_' . $args['reportName'] . '.php');
	}

	function audit_log($f3) {
		$eventDao = new \models\EventDao();

		$f3->set('events', $eventDao->readEvents());

		echo \View::instance()->render('administration/audit_log.php');
	}

	function list_export_csv($f3) {
		$registrationDao = new \models\RegistrationDao();

		$registrationFields = $registrationDao->readAllRegistrationFieldNames();
		$registrations = $registrationDao->readAllRegistrationForms(null, true);

		foreach ($registrationFields as $field) {
			foreach ($registrations as $index => $registration) {
				if (!array_key_exists($field, $registration)) {
					$registrations[$index][$field] = '';
				}
			}
		}

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="tli-registrations-'
			. strftime('%Y%m%d') . '-' . strftime('%H%M') . '.csv"');

		$output = fopen('php://output', 'w');

		$headings = array_merge([
			'id_registration',
			'email',
			'status',
			'date_entered',
			'date_paid',
			], $registrationFields);
		sort($headings);
		fputcsv($output, $headings, ';');

		foreach ($registrations as $registration) {
			ksort($registration);
			foreach ($registration as $field => $value) {
				if (is_array($value))
					$registration[$field] = implode(',', $value);
			}
			fputcsv($output, $registration, ';');
		}
		fclose($output);
	}

}
