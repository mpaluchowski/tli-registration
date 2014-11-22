<?php

namespace controllers;

class Payment {

	function pay($f3, $args) {
		if (!is_string($args['registrationHash']) && 40 != strlen($args['registrationHash'] + 0))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();
		$form = $registrationDao->readRegistrationFormByHash($args['registrationHash']);

		if (!$form)
			$f3->error(404);

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

		$priceCalculator = \models\PriceCalculatorFactory::newInstance();
		$totalPrice = $priceCalculator->calculateSummary($form)['total'];

		// Create and save a new transaction
		$transactionDao = new \models\TransactionDao();

		$transaction = new \models\Transaction(
			$transactionDao->generateSessionId(),
			$form->getId(),
			$totalPrice[$transactionDao->getDefaultPaymentCurrency()],
			$transactionDao->getDefaultPaymentCurrency(),
			$transactionDao->getDefaultPaymentDescription(),
			$form->getEmail(),
			$transactionDao->getDefaultPaymentCountry()
			);

		$transactionDao->saveTransaction($transaction);

		$paymentProcessor = \models\PaymentProcessorFactory::instance();

		// Register transaction with processor
		$token = $paymentProcessor->registerTransaction(
			$transaction,
			\helpers\View::getBaseUrl() . \F3::get('ALIASES.payment_confirmation'),
			\helpers\View::getBaseUrl() . \F3::get('ALIASES.payment_status_receive')
			);

		// Redirect to payments page
		$f3->reroute($paymentProcessor->getPaymentPageUrl($token));
	}

	function confirmation($f3, $args) {
		if (!is_string($args['registrationHash']) && 40 != strlen($args['registrationHash'] + 0))
			$f3->error(404);

		print_r($f3->get('POST'));
	}

}
