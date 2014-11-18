<?php

namespace helpers;

/**
 * Supplies references to the configured FormRenderer implementation.
 */
class FormRendererFactory {

	/**
	 * @return class name of the FormRenderer implementation
	 * @throws exception when FormRenderer impmentation not configured
	 */
	static function className() {
		self::checkConfig();
		return \F3::get('form_renderer');
	}

	/**
	 * @return object instance of the FormRenderer implementation
	 * @throws exception when FormRenderer impmentation not configured
	 */
	static function instance() {
		self::checkConfig();
		$name = \F3::get('form_renderer');
		return new $name;
	}

	/**
	 * Check if implementation of FormRenderer is correctly configured. Throw
	 * exception if not.
	 */
	private static function checkConfig() {
		if (!\F3::get('form_renderer'))
			throw new \Exception('form_renderer configuration cannot be empty. Enter the full classpath of the \helpers\FormRenderer implementation.');
	}

}
