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

		$registrations = $registrationDao->readAllRegistrationForms();
		usort($registrations, "\helpers\Sorters::sortRegistrationsByFullName");

		$f3->set('stats', $registrationDao->readRegistrationStatistics());
		$f3->set('fieldColumns', $registrationDao->readAllRegistrationFieldNames());
		$f3->set('registrations', $registrations);

		echo \View::instance()->render('administration/list_registrations.php');
	}

	function statistics($f3) {
		$registrationDao = new \models\RegistrationDao();

		if (\models\RegistrationDao::isSeatingLimited()) {
			$f3->set('totalSeats', \models\RegistrationDao::getSeatLimit());
		}
		$f3->set('stats', $registrationDao->readRegistrationStatistics());
		$f3->set('registrationsByWeek', $registrationDao->readRegistrationsByWeekStatistics());

		echo \View::instance()->render('administration/statistics.php');
	}

	function list_export_csv($f3) {
		$registrationDao = new \models\RegistrationDao();

		$registrationFields = $registrationDao->readAllRegistrationFieldNames();
		$registrations = $registrationDao->readAllRegistrationForms(true);

		foreach ($registrationFields as $field) {
			foreach ($registrations as $index => $registration) {
				if (!array_key_exists($field, $registration)) {
					$registrations[$index][$field] = '';
				}
			}
		}

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="tli-registrations-' . strftime('%Y-%m-%d') . '.csv"');

		$output = fopen('php://output', 'w');

		$headings = array_merge([
			'id_registration',
			'email',
			'is_waiting_list',
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
