<?php

namespace models;

/**
 * Common interface for all payment processing services.
 */
interface PaymentProcessor {

	/**
	 * Register a new transaction with the payment processor.
	 *
	 * @return Token representing the transaction at the payment processor to
	 * redirect the user to the payment selection screen.
	 */
	function registerTransaction(
		\models\Transaction $transaction,
		$returnUrl,
		$statusUrl
		);

	/**
	 * Produce the URL of the payment selection screen of the processor to
	 * redirect the user to.
	 *
	 * @param token the transaction token received from the payment processor.
	 */
	function getPaymentPageUrl($token);

	function processTransactionConfirmation(
		array $postParameters,
		\models\Transaction &$transaction
		);

	/**
	 * Test if the connection with the payment processor is working correctly.
	 */
	function testConnection();

	/**
	 * Find and return the session ID in the POST parameters sent in by the
	 * payment processor.
	 *
	 * @param postParameters array with POST parameters from the request.
	 * @return value of the session ID found in the POST parameters.
	 */
	function extractSessionId(array $postParameters);

	/**
	 * @return true if the payment processor is working in test mode, so not
	 * processing actual transactions.
	 */
	static function isTestMode();

	/**
	 * @return true if the payment processor has a test mode available, to check
	 * the flow without processing live transactions.
	 */
	static function hasTestMode();

}
