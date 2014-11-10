<?php

namespace models;

class PriceCalculatorImpl implements PriceCalculator {

	function __construct() {
		if (!\F3::exists('db')) {
			\F3::set('db', new \DB\SQL(
				'mysql:host=' . \F3::get('db_host') . ';port=' . \F3::get('db_port') . ';dbname='.\F3::get('db_database'),
				\F3::get('db_username'),
				\F3::get('db_password'),
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
				));
		}
	}

	/**
	 * @see \models\PriceCalculatorImpl#calculateSummary($form, $time)
	 */
	function calculateSummary(\models\RegistrationForm $form, $time = null) {
		$pricing = $this->fetchPricing($time);

		$summary = [
			'admission' => $pricing['admission'],
		];

		if ($form->hasField('lunch')
				&& "on" === $form->getField('lunch')
				&& $form->hasField('lunch-days')) {
			$summary['lunch'] = $pricing['lunch'];
			// Multiply lunch price per day by number of days
			foreach ($summary['lunch']->prices as $currency => $price) {
				$summary['lunch']->prices[$currency] *= count($form->getField('lunch-days'));
			}
		}

		if ($form->hasField('saturday-dinner-participate')
				&& "on" === $form->getField('saturday-dinner-participate')) {
			$summary['saturday-dinner-participate'] = $pricing[
					'saturday-dinner-participate-' . $form->getField('saturday-dinner-meal')
				];
		}

		if ($form->hasField('saturday-party-participate')
				&& "on" === $form->getField('saturday-party-participate')) {
			$summary['saturday-party-participate']
				= $pricing['saturday-party-participate'];
		}

		$total = [];
		foreach ($summary as $item) {
			foreach ($item->prices as $currency => $price) {
				if (!array_key_exists($currency, $total))
					$total[$currency] = 0;
				$total[$currency] += $price;
			}
		}
		$summary['total'] = $total;

		return $summary;
	}

	/**
	 * Retrieves pricing details from the database, for a given moment in time.
	 * Accounts for some prices being time-sensitive, ie. changing over time.
	 *
	 * @param time optional time to return prices for. Default is now.
	 * @return pricing structure with all available options and variants.
	 */
	public function fetchPricing($time = null) {
		if (!$time) $time = time();

		$query = 'SELECT pi.item,
						 pi.variant,
						 pi.date_valid_through,
						 GROUP_CONCAT(CONCAT(pp.currency, ";", pp.price) ORDER BY pp.currency SEPARATOR "|") AS prices
				  FROM ' . \F3::get('db_table_prefix') . 'pricing_items pi
				  JOIN ' . \F3::get('db_table_prefix') . 'pricing_prices pp
				    ON pi.id_pricing_item = pp.fk_pricing_item
				  WHERE pi.date_valid_through IS NULL
				     OR pi.date_valid_through IN (
							SELECT MIN(pi.date_valid_through)
							FROM ' . \F3::get('db_table_prefix') . 'pricing_items pi
							WHERE pi.date_valid_through IS NOT NULL
							  AND FROM_UNIXTIME(:datetime) < pi.date_valid_through
							GROUP BY pi.item
				     	)
				  GROUP BY pi.id_pricing_item
				  ';
		$rows = \F3::get('db')->exec($query, [
				'datetime' => $time
			]);

		$pricing = [];
		foreach ($rows as $row) {
			$pricing[$row['item'] . ($row['item'] != 'admission' && $row['variant'] ? '-' . $row['variant'] : '')] = (object)[
				'variant' => $row['variant'],
				'dateValidThrough' => $row['date_valid_through'],
				'prices' => $this->explodePrices($row['prices']),
			];
		}
		return $pricing;
	}

	/**
	 * Explode the pricing information with currencies returned as single string
	 * from the database.
	 *
	 * @param prices delimited string with pricing information, expected format
	 * 'EUR;10|PLN;15'
	 * @return array with elements for each currency, each key being the currency
	 * code and value the price in that currency.
	 */
	private function explodePrices($prices) {
		preg_match_all("/([^\|]+);([^\|]+)/", $prices, $pairs);
		return array_combine($pairs[1], $pairs[2]);
	}

}
