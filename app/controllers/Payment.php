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

		$transactionDao = new \models\TransactionDao();

		$transaction = $transactionDao->readTransactionByRegistrationId(
			$form->getId()
			);

		if ('PENDING_PAYMENT' !== $form->getStatus()) {
			\models\MessageManager::addMessage(
				'warning',
				$f3->get(
						'lang.PaymentProcessing-' . $form->getStatus(),
						[
							strftime('%c', strtotime($form->getDatePaid())),
							!$transaction ? : strftime('%c', strtotime($transaction->getDateStarted()))
						]
					)
			);
			$f3->reroute('@registration_review');
		}

		// Start new transaction if none found so far. Could happen if we saved
		// a transactio on our side previously, but it didn't reach the payment
		// processor.
		if (!$transaction) {
			$priceCalculator = \models\PriceCalculatorFactory::newInstance();
			$totalPrice = $priceCalculator->calculateSummary($form)['total'];

			// Create and save a new transaction
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
		}

		$paymentProcessor = \models\PaymentProcessorFactory::instance();

		try {
			// Register transaction with processor
			$token = $paymentProcessor->registerTransaction(
				$transaction,
				\helpers\View::getBaseUrl() . \F3::get('ALIASES.payment_confirmation'),
				\helpers\View::getBaseUrl() . \F3::get('ALIASES.payment_status_receive'),
				\helpers\View::getCurrentLanguage()
				);
		} catch (\models\PaymentProcessorCallException $e) {
			$logger = new \Log($f3->get('logfile_error'));
			$logger->write('ERROR: ' . print_r($e, true));

			\models\MessageManager::addMessage(
				'danger',
				$f3->get('lang.PaymentProcessingErrorMsg')
			);
			$f3->reroute('@registration_review');
		}

		// Redirect to payments page
		$f3->reroute($paymentProcessor->getPaymentPageUrl($token));
	}

	function confirmation($f3, $args) {
		if (!is_string($args['registrationHash']) && 40 != strlen($args['registrationHash'] + 0))
			$f3->error(404);

		$transactionDao = new \models\TransactionDao();
		$paymentProcessor = \models\PaymentProcessorFactory::instance();

		// We may have the session ID from the payment processor
		if ($f3->get('POST')
				&& $paymentProcessor->extractSessionId($f3->get('POST'))) {
			// Read transaction from the session id provided
			$transaction = $transactionDao->readTransactionBySessionId(
				$paymentProcessor->extractSessionId($f3->get('POST'))
				);
		} else {
			// Read Transaction via the registration hash
			$registrationDao = new \models\RegistrationDao();
			$form = $registrationDao->readRegistrationFormByHash($args['registrationHash']);
			$transaction = $transactionDao->readTransactionByRegistrationId(
				$form->getId()
				);
		}

		// May only happen if someone calls this action without going through
		// pay() first
		if (!$transaction)
			$f3->reroute('@registration_review');

		// Check if transaction already confirmed with payment processor
		if (!$transaction->getDatePaid()) {
			// Mark the registration as payment being processed
			$registrationDao->updateRegistrationStatusToProcessingPayment($form->getId());
			$msg = 'lang.PaymentProcessing-PROCESSING_PAYMENT';
		} else {
			// Already received confirmation, inform user
			$msg = 'lang.PaymentProcessing-PAID';
		}
		\models\MessageManager::addMessage(
			'success',
			$f3->get(
					$msg,
					[
						$transaction->getDateStarted(),
						$transaction->getDatePaid(),
					]
				)
		);

		$f3->reroute('@registration_review');
	}

	function status_receive($f3) {
		$transactionDao = new \models\TransactionDao();
		$paymentProcessor = \models\PaymentProcessorFactory::instance();

		$transaction = $transactionDao->readTransactionBySessionId(
			$paymentProcessor->extractSessionId($f3->get('POST'))
			);

		// Check incoming transaction parameters against the ones stored
		$result = $paymentProcessor->processTransactionConfirmation(
			$f3->get('POST'),
			$transaction
			);

		if ($result) {
			// Update stored transaction with details from processor
			$transactionDao->updateTransactionPostPayment(
				$transaction->getSessionId(),
				$transaction->getOrderId(),
				$transaction->getMethod(),
				$transaction->getStatement()
				);

			// Confirm to the processor that the transaction is valid
			$paymentProcessor->verifyTransaction($transaction);

			$registrationDao = new \models\RegistrationDao();

			// Mark the registration is paid
			$registrationDao->updateRegistrationStatusToPaid(
				$transaction->getRegistrationId()
				);

			// Send email confirming payment received
			$form = $registrationDao->readRegistrationFormByEmail($args['email']);

			$f3->set('registrationReviewUrl', \helpers\View::getBaseUrl() . '/registration/review/' . $form->getHash());
			$f3->set('form', $form);

			$mailer = new \models\Mailer();

			$mailer->sendEmail(
				$args['email'],
				$f3->get('lang.EmailRegistrationConfirmationSubject', $args['email']),
				\View::instance()->render('mail/registration_confirm.php')
				);
		}
	}

}
