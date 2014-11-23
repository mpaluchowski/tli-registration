<?php

namespace models;

/**
 * PaymentProcessor implementation for the Polish www.przelewy24.pl processing
 * service.
 */
class Przelewy24PaymentProcessor implements \models\PaymentProcessor {

	const
		P24_VERSION 		= "3.2",
		HOST_LIVE 			= "https://secure.przelewy24.pl/",
		HOST_SANDBOX 		= "https://sandbox.przelewy24.pl/",
		ENDPOINT_REGISTER	= "trnRegister",
		ENDPOINT_REQUEST	= "trnRequest",
		ENDPOINT_VERIFY		= "trnVerify",
		ENDPOINT_TEST		= "testConnection",
		CONFIG_PREFIX		= "p24";

	/**
	 * @see \models\PaymentProcessor#registerTransaction(\models\Transaction $transaction, $returnUrl, $statusUrl)
	 */
	function registerTransaction(\models\Transaction $transaction, $returnUrl, $statusUrl) {
		$response = $this->callService(
			self::ENDPOINT_REGISTER, [
				'p24_session_id' => $transaction->getSessionId(),
				'p24_amount' => $this->parseAmountToInt($transaction->getAmount()),
				'p24_currency' => $transaction->getCurrency(),
				'p24_description' => $transaction->getDescription(),
				'p24_email' => $transaction->getEmail(),
				'p24_country' => $transaction->getCountryCode(),
				'p24_url_return' => $returnUrl,
				'p24_url_status' => $statusUrl,
				'p24_sign' => $this->calculateSign([
					$transaction->getSessionId(),
					$this->getConfig('pos_id'),
					$this->parseAmountToInt($transaction->getAmount()),
					$transaction->getCurrency(),
					])
				]
			);

		return $response['token'];
	}

	/**
	 * @see \models\PaymentProcessor#getPaymentPageUrl($token)
	 */
	function getPaymentPageUrl($token) {
		return $this->getHost() . self::ENDPOINT_REQUEST . "/" . $token;
	}

	/**
	 * @see \models\PaymentProcessor#processTransactionConfirmation(array $postParameters, \models\Transaction &$transaction)
	 */
	function processTransactionConfirmation(array $postParameters, \models\Transaction &$transaction) {
		$verification = $postParameters['p24_merchant_id'] == $this->getConfig('merchant_id')
			&& $postParameters['p24_pos_id'] == $this->getConfig('pos_id')
			&& $postParameters['p24_session_id'] == $transaction->getSessionId()
			&& $postParameters['p24_amount'] == $this->parseAmountToInt($transaction->getAmount())
			&& $postParameters['p24_currency'] == $transaction->getCurrency()
			&& $postParameters['p24_sign'] == $this->calculateSign([
				$postParameters['p24_session_id'],
				$postParameters['p24_order_id'],
				$postParameters['p24_amount'],
				$postParameters['p24_currency']
				]);

		if (!$verification)
			return false;

		$transaction->setOrderId($postParameters['p24_order_id']);
		$transaction->setMethod($postParameters['p24_method']);
		$transaction->setStatement($postParameters['p24_statement']);

		return $transaction;
	}

	/**
	 * @see \models\PaymentProcessor#verifyTransaction(\models\Transaction $transaction)
	 */
	function verifyTransaction(\models\Transaction $transaction) {
		$response = $this->callService(
			self::ENDPOINT_VERIFY, [
				'p24_session_id' => $transaction->getSessionId(),
				'p24_amount' => $this->parseAmountToInt($transaction->getAmount()),
				'p24_currency' => $transaction->getCurrency(),
				'p24_order_id' => $transaction->getOrderId(),
				'p24_sign' => $this->calculateSign([
					$transaction->getSessionId(),
					$transaction->getOrderId(),
					$this->parseAmountToInt($transaction->getAmount()),
					$transaction->getCurrency(),
					])
			]);

		return $response['error'] == 0;
	}

	/**
	 * @see \models\PaymentProcessor#testConnection()
	 */
	function testConnection() {
		return $this->callService(
			self::ENDPOINT_TEST, [
				'p24_sign' => $this->calculateSign([$this->getConfig('pos_id')]),
				]
			);
	}

	/**
	 * @see \models\PaymentProcessor#extractSessionId(array $postParameters)
	 */
	function extractSessionId(array $postParameters) {
		return $postParameters['p24_session_id'];
	}

	/**
	 * @see \models\PaymentProcessor#isTestMode()
	 */
	static function isTestMode() {
		return (bool)\F3::get('payment_processor_test_mode');
	}

	/**
	 * @see \models\PaymentProcessor#hasTestMode()
	 */
	static function hasTestMode() {
		return true;
	}

	/**
	 * Parse the float amount to int, formatted as P24 wants it. Will move the
	 * decimal sign two digits to the right.
	 *
	 * @return integer form of the float amount.
	 */
	protected function parseAmountToInt($amount) {
		return (int)($amount * 100);
	}

	/**
	 * Calculate the CRC verification sign from a set of elements to add to
	 * P24 requests.
	 *
	 * @param elements array of elements to put into the sign, in order they
	 * should be added in.
	 * @return MD5 hash of the concatenated elemnts and configured CRC key.
	 */
	protected function calculateSign(array $elements) {
		$elements[] = $this->getConfig('crc');
		return md5(implode("|", $elements));
	}

	/**
	 * Get the host to connect to, sandbox or live.
	 *
	 * @return hostname to connect to at Przelewy24.
	 */
	protected function getHost() {
		return $this->isTestMode()
			? self::HOST_SANDBOX
			: self::HOST_LIVE;
	}

	/**
	 * Get configuration value for Przelewy24, automatically prefixing the
	 * key.
	 *
	 * @param key configuration key to seek value for.
	 * @return value of configuration for the given key, or null if not found.
	 */
	protected function getConfig($key) {
		return \F3::get(self::CONFIG_PREFIX . '_' . $key);
	}

	/**
	 * Call Przelewy24 webservice. Will add common arguments before sending the
	 * request.
	 *
	 * @param endpoint the exact endpoint to connect to at Przelewy24.
	 * @param args the arguments to send to Przelewy24.
	 * @return body structure of the HTTP return call.
	 */
	protected function callService($endpoint, array $args) {
		// Add args common to all calls
		$args['p24_merchant_id'] = $this->getConfig('merchant_id');
		$args['p24_pos_id'] = $this->getConfig('pos_id');
		$args['p24_api_version'] = self::P24_VERSION;

		$web = new \Web;
		$result = $web->request(
			$this->getHost() . $endpoint,
			[
				'method' => 'POST',
				'content' => http_build_query($args),
			]
			);

		parse_str($result['body'], $output);
		return $output;
	}

}
