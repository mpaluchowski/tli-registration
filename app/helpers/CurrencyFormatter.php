<?php

namespace helpers;

class CurrencyFormatter {

	const currencies = [
		'EUR' => ['symbol' => '€'],
		'PLN' => ['symbol' => 'zł', 'suffix' => true],
	];

	static function moneyFormat($currency, $number, $decimals = 2) {
		return array_key_exists('suffix', self::currencies[$currency])
				&& self::currencies[$currency]['suffix']
			? number_format($number, 2) . self::currencies[$currency]['symbol']
			: self::currencies[$currency]['symbol'] . ' ' . number_format($number, $decimals);
	}

	static function getSymbol($currency) {
		return self::currencies[$currency]['symbol'];
	}

}
