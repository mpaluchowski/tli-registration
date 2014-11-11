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

}
