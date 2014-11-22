<?php

namespace models;

/**
 * Supplies instances of the configured PaymentProcessor implementation.
 */
class PaymentProcessorFactory {

	/**
	 * @return instance of a \models\PaymentProcessor implementation configured
	 * for use via config.ini.
	 * @throws exception when no PaymentProcessor implementation is configured.
	 */
	static function instance() {
		if (!\F3::get('payment_processor'))
			throw new \Exception("payment_processor configuration cannot be empty. Enter the full classpath of the \models\PaymentProcessor implementation.");

		$name = \F3::get('payment_processor');
		return new $name;
	}

}
