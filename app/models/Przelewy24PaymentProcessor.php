<?php

namespace models;

class Przelewy24PaymentProcessor implements \models\PaymentProcessor {

	const
		P24_VERSION 		= "3.2",
		HOST_LIVE 			= "https://secure.przelewy24.pl/",
		HOST_SANDBOX 		= "https://sandbox.przelewy24.pl/",
		ENDPOINT_TEST		= "testConnection",
		CONFIG_PREFIX		= "p24";

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
