<?php

namespace controllers;

class Payment {

	function pay($f3, $args) {
		if (!is_string($args['registrationHash']) && 40 != strlen($args['registrationHash'] + 0))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();
		$form = $registrationDao->readRegistrationFormByHash($args['registrationHash']);

		if ('PENDING_PAYMENT' !== $form->getStatus()) {
			\models\MessageManager::addMessage(
				'warning',
				$f3->get(
						'lang.PaymentCannotProceed-' . $form->getStatus(),
						strftime('%c', strtotime($form->getDatePaid()))
					)
			);
			$f3->reroute('@registration_review(@registrationHash=' . $form->getHash() . ')');
		}
	}

}
