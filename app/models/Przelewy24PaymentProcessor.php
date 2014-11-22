<?php

namespace models;

class Przelewy24PaymentProcessor implements \models\PaymentProcessor {

	const
		P24_VERSION 		= "3.2",
		HOST_LIVE 			= "https://secure.przelewy24.pl/",
		HOST_SANDBOX 		= "https://sandbox.przelewy24.pl/",
		ENDPOINT_REGISTER	= "trnRegister",
		ENDPOINT_REQUEST	= "trnRequest",
		ENDPOINT_TEST		= "testConnection",
		CONFIG_PREFIX		= "p24";

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

	function getPaymentPageUrl($token) {
		return $this->getHost() . self::ENDPOINT_REQUEST . "/" . $token;
	}

	function testConnection() {
		return $this->callService(
			self::ENDPOINT_TEST, [
				'p24_sign' => $this->calculateSign([$this->getConfig('pos_id')]),
				]
			);
	}

	function isTestMode() {
		return (bool)\F3::get('payment_processor_test_mode');
	}

	function hasTestMode() {
		return true;
	}

	protected function parseAmountToInt($amount) {
		return (int)($amount * 100);
	}

	protected function calculateSign(array $elements) {
		$elements[] = $this->getConfig('crc');
		return md5(implode("|", $elements));
	}

	protected function getHost() {
		return $this->isTestMode()
			? self::HOST_SANDBOX
			: self::HOST_LIVE;
	}

	protected function getConfig($key) {
		return \F3::get(self::CONFIG_PREFIX . '_' . $key);
	}

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
