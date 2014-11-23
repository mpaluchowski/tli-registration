<?php

namespace models;

/**
 * Supplies instances of the configured PaymentProcessor implementation.
 */
class PaymentProcessorFactory {

	/**
	 * @return class name of the PaymentProcessor implementation
	 * @throws exception when no PaymentProcessor implementation is configured
	 */
	static function className() {
		self::checkConfig();
		return \F3::get('payment_processor');
	}

	/**
	 * @return instance of a \models\PaymentProcessor implementation configured
	 * for use via config.ini.
	 * @throws exception when no PaymentProcessor implementation is configured.
	 */
	static function instance() {
		self::checkConfig();
		$name = \F3::get('payment_processor');
		return new $name;
	}

	/**
	 * Check if implementation of PaymentProcessor is correctly configured.
	 * Throw exception if not.
	 */
	protected static function checkConfig() {
		if (!\F3::get('payment_processor'))
			throw new \Exception("payment_processor configuration cannot be empty. Enter the full classpath of the \models\PaymentProcessor implementation.");
	}

}
