<?php

namespace models;

/**
 * Provides instances of \models\PriceCalculator implementations.
 */
abstract class PriceCalculatorFactory {

	/**
	 * Return a new instance of a PriceCalculator implementation.
	 *
	 * @return new instance of what's configured as the PriceCalculator
	 * implementation.
	 * @throws Exception when form_price_calculator configuration string missing.
	 */
	static function newInstance() {
		if (!\F3::get('form_price_calculator'))
			throw new \Exception('form_price_calculator configuration cannot be empty. Enter the full classpath of the \models\PriceCalculator implementation.');

		$priceCalculatorName = \F3::get('form_price_calculator');
		return new $priceCalculatorName;
	}

}
