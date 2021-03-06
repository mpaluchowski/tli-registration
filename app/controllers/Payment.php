<?php

namespace controllers;

class Payment {

	function pay($f3, $args) {
		if (!\models\RegistrationDao::validateHash($args['registrationHash']))
			$f3->error(404);

		$registrationDao = new \models\RegistrationDao();
		$form = $registrationDao->readRegistrationFormByHash($args['registrationHash']);

		if (!$form)
			$f3->error(404);

		$transactionDao = new \models\TransactionDao();

		$transaction = $transactionDao->readTransactionByRegistrationId(
			$form->getId()
			);

		if ('pending-payment' !== $form->getStatus()) {
			\models\MessageManager::addMessage(
				$transaction ? 'success' : 'warning',
				$f3->get(
						'lang.PaymentProcessing-' . $form->getStatus(),
						[
							!$transaction ? : \helpers\View::formatDateTime($transaction->getDateStarted()),
							\helpers\View::formatDateTime($form->getDatePaid()),
						]
					)
			);
			$f3->reroute('@registration_review');
		}

		$paymentProcessor = \models\PaymentProcessorFactory::instance();

		// Start new transaction if none found so far. Could happen if we saved
		// a transactio on our side previously, but it didn't reach the payment
		// processor.
		if (!$transaction) {
			$priceCalculator = \models\PriceCalculatorFactory::newInstance();
			$totalPrice = $priceCalculator->calculateSummary($form)['total'];

			$startedTimestamp = time();
			$validTimestamp = $paymentProcessor->getValidDate($startedTimestamp);

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
			$transaction->setDateStarted(date('Y-m-d H:i:s', $startedTimestamp));
			$transaction->setDateValid(date('Y-m-d H:i:s', $validTimestamp));

			$transactionDao->saveTransaction($transaction);
		}

		try {
			// Register transaction with processor
			$token = $paymentProcessor->registerTransaction(
				$transaction,
				\helpers\View::getBaseUrl() . \F3::get('ALIASES.payment_confirmation'),
				\helpers\View::getBaseUrl() . \F3::get('ALIASES.payment_status_receive'),
				\models\L11nManager::language()
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
		if (!\models\RegistrationDao::validateHash($args['registrationHash']))
			$f3->error(404);

		$transactionDao = new \models\TransactionDao();
		$registrationDao = new \models\RegistrationDao();
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
			$form = $registrationDao->readRegistrationFormByHash($args['registrationHash']);
			$transaction = $transactionDao->readTransactionByRegistrationId(
				$form->getId()
				);
		}

		// May only happen if someone calls this action without going through
		// pay() first
		if (!$transaction)
			$f3->reroute('@registration_review');

		// Check if transaction already confirmed with payment processor,
		// otherwise no message because we can't distinguish the reason why a
		// person's been redirected back. Might've just cancelled transaction.
		if ($transaction->getDatePaid()) {
			$msg = 'lang.PaymentProcessing-paid';
		} else {
			$msg = 'lang.PaymentProcessing-processing-payment';
		}

		\models\MessageManager::addMessage(
			'success',
			$f3->get(
				$msg,
				[
					\helpers\View::formatDateTime($transaction->getDateStarted()),
					\helpers\View::formatDateTime($transaction->getDatePaid()),
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

		if (!$transaction) {
			$logger = new \Log($f3->get('logfile_error'));
			$logger->write('ERROR: Transaction not found after PaymentProcessor sent confirmation' . PHP_EOL
				. print_r($f3->get('POST'), true));
			$f3->error(400);
		}

		// Check incoming transaction parameters against the ones stored
		$result = $paymentProcessor->processTransactionConfirmation(
			$f3->get('POST'),
			$transaction
			);

		if (!$result) {
			$logger = new \Log($f3->get('logfile_error'));
			$logger->write('ERROR: Package verification from PaymentProcessor failed' . PHP_EOL
				. print_r($f3->get('POST'), true));
			$f3->error(400);
		}

		// Idempotence. Only update transaction if not previously paid.
		if (!$transaction->getDatePaid()) {
			// Update stored transaction with details from processor
			$transactionDao->updateTransactionPostPayment(
				$transaction->getSessionId(),
				$transaction->getOrderId(),
				$transaction->getMethod(),
				$transaction->getStatement()
				);
		}

		// Confirm to the processor that the transaction is valid
		try {
			$result = $paymentProcessor->verifyTransaction($transaction);
		} catch (\models\PaymentProcessorCallException $e) {
			$logger = new \Log($f3->get('logfile_error'));
			$logger->write('ERROR: ' . print_r($e, true));
			$logger->write('ERROR: Transaction verification with PaymentProcessor failed' . PHP_EOL
				. print_r($f3->get('POST'), true));
			$f3->error(500);
		}

		if (!$result) {
			$logger = new \Log($f3->get('logfile_error'));
			$logger->write('ERROR: Transaction verification with PaymentProcessor failed' . PHP_EOL
				. print_r($f3->get('POST'), true));
			$f3->error(500);
		}

		$registrationDao = new \models\RegistrationDao();

		// Send email confirming payment received
		$form = $registrationDao->readRegistrationFormById($transaction->getRegistrationId());

		// Idempotence. Only update registration if not previously paid.
		if (!$form->getDatePaid()) {
			// Mark the registration is paid
			$registrationDao->updateRegistrationStatus($form, 'paid');
		}

		// Notify registrant that the payment was received
		\models\L11nManager::setLanguage($form->getLanguageEntered());

		$f3->set('registrationReviewUrl', \helpers\View::getBaseUrl() . '/registration/review/' . $form->getHash());
		$f3->set('form', $form);

		$mailer = new \models\Mailer();

		$mailer->sendEmail(
			$form->getEmail(),
			$f3->get('lang.EmailRegistrationConfirmationSubject', $form->getEmail()),
			\View::instance()->render('mail/registration_confirm.php')
			);

		// Check if any seats are still available, or if we need to switch all
		// remaining registrations pending-payment to waiting-list
		if (0 === $registrationDao->readSeatsLeft()) {
			$registrationIds =
				$registrationDao->updatePendingPaymentRegistrationsToWaitingList();

			// Email each of the affected registrants
			foreach ($registrationIds as $registrationId) {
				$form = $registrationDao->readRegistrationFormById($registrationId);
				\models\L11nManager::setLanguage($form->getLanguageEntered());
				$f3->set('registrationReviewUrl', \helpers\View::getBaseUrl() . '/registration/review/' . $form->getHash());
				$f3->set('form', $form);

				$mailer->sendEmail(
					$form->getEmail(),
					$f3->get('lang.EmailRegistrationConfirmationSubject', $form->getEmail()),
					\View::instance()->render('mail/registration_confirm.php')
					);
			}
		}
	}

}
