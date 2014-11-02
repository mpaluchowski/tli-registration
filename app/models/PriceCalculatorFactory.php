<?php

namespace models;

abstract class PriceCalculatorFactory {

	static function newInstance() {
		if (!\F3::get('form_price_calculator'))
			throw new \Exception('form_price_calculator configuration cannot be empty. Enter the full classpath of the \models\PriceCalculator implementation.');

		$priceCalculatorName = \F3::get('form_price_calculator');
		return new $priceCalculatorName;
	}

}
