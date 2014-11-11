<?php

namespace helpers;

/**
 * Helps in formatting currency values by catering for the right symbols and
 * their placement against the number.
 */
class CurrencyFormatter {

	/** Currency configuration */
	private static $currencies = [
		'EUR' => ['symbol' => '€'],
		'PLN' => ['symbol' => 'zł', 'suffix' => true],
		'USD' => ['symbol' => '$'],
	];

	/**
	 * Formats a number for a given currency.
	 *
	 * @param currency The ISO code for the currency to use.
	 * @param number The numeric value to display.
	 * @param decimals How many decimal numbers to include.
	 * @return String with the official currency display, value and symbol.
	 */
	static function moneyFormat($currency, $number, $decimals = 2) {
		return array_key_exists('suffix', self::$currencies[$currency])
				&& self::$currencies[$currency]['suffix']
			? number_format($number, $decimals) . self::$currencies[$currency]['symbol']
			: self::$currencies[$currency]['symbol'] . ' ' . number_format($number, $decimals);
	}

	/**
	 * Formats an array of prices, supplied as [currency => price].
	 *
	 * @param prices array of prices to format.
	 * @param decimals how many decimal numbers to include.
	 * @return array with prices formatted according to currency rules.
	 */
	static function moneyFormatArray(array $prices, $decimals = 2) {
		return array_map(function($currency, $price) use ($decimals) {
			return self::moneyFormat($currency, $price, $decimals);
		}, array_keys($prices), $prices);
	}

	/**
	 * Retrieves the custom symbol for a currency.
	 *
	 * @param currency ISO currency code.
	 * @return Sumbol for the currency.
	 */
	static function getSymbol($currency) {
		return self::$currencies[$currency]['symbol'];
	}

}
