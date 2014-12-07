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

	function codes($f3) {
		$priceCalculator = \models\PriceCalculatorFactory::newInstance();

		$f3->set('pricingItems', $priceCalculator->fetchPricing());

		$discountCodeDao = new \models\DiscountCodeDao();

		$f3->set('discountCodes', $discountCodeDao->readAllDiscountCodes());

		echo \View::instance()->render('administration/codes.php');
	}

	function code_create($f3) {
		$discountCodeDao = new \models\DiscountCodeDao();

		$code = $discountCodeDao->parseRequestToCode($f3->get('POST'));

		$codeId = $discountCodeDao->saveDiscountCode($code);

		$eventDao = new \models\EventDao();
		$eventDao->saveEvent(
			"DiscountCodeGenerate",
			$f3->get('user')->id,
			["email" => $code->getEmail()],
			'DiscountCode',
			$codeId
			);
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
