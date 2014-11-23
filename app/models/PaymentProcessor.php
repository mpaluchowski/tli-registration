<?php

namespace models;

/**
 * Common interface for all payment processing services.
 */
interface PaymentProcessor {

	/**
	 * Register a new transaction with the payment processor.
	 *
	 * @param transaction the \models\Transaction instance with transaction
	 * data
	 * @param returnUrl the URL to redirect user after payment
	 * @param statusUrl the URL for the payment processing system to report
	 * status back to
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

	/**
	 * Process transaction status update coming from the Payment Processor to
	 * see if all data is correct and extract statement data produced by the
	 * processing party.
	 *
	 * @param postParameters the POST parameters received from the processor.
	 * @param transaction transaction details stored in our system for comparison
	 * and amending with new data.
	 * @return transaction details with added statement data from the payment
	 * processor, or false if stored data don't match incoming data.
	 */
	function processTransactionConfirmation(
		array $postParameters,
		\models\Transaction &$transaction
		);

	/**
	 * Confirm to the payment processor that the transaction is correct and can
	 * be cleared.
	 *
	 * @param transaction the transactio details.
	 */
	function verifyTransaction(\models\Transaction $transaction);

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
