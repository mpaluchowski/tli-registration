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
	 * @see \models\PriceCalculatorImpl#calculateSummary($form, $discounts, $time)
	 */
	function calculateSummary(\models\RegistrationForm $form, $discounts = true, $time = null) {
		$pricing = $this->fetchPricing($time);

		if ($discounts) {
			// Fetch discounts, if any
			$discountCodeDao = new \models\DiscountCodeDao();
			$discountPricing = $discountCodeDao->readDiscountsByRegistrationId($form->getId());
		} else {
			$discountPricing = [];
		}

		$summary = [
			'admission' => self::getPriceItem('admission', $pricing, $discountPricing)
		];

		if ($form->hasField('lunch')
				&& "on" === $form->getField('lunch')
				&& $form->hasField('lunch-days')) {
			$summary['lunch'] = self::getPriceItem('lunch', $pricing, $discountPricing);

			// Multiply lunch price per day by number of days
			foreach ($summary['lunch']->prices as $currency => $price) {
				$summary['lunch']->prices[$currency]
						*= count($form->getField('lunch-days'));

				if (property_exists($summary['lunch'], 'pricesOriginal'))
					$summary['lunch']->pricesOriginal[$currency]
							*= count($form->getField('lunch-days'));
			}
		}

		if ($form->hasField('friday-copernicus-attend')
				&& "on" === $form->getField('friday-copernicus-attend')
				&& $form->hasField('friday-copernicus-options')) {
			foreach ($form->getField('friday-copernicus-options') as $option) {
				$summary['friday-copernicus-attend-' . $option] =
					self::getPriceItem('friday-copernicus-attend-' . $option, $pricing, $discountPricing);
			}
		}

		if ($form->hasField('saturday-dinner-participate')
				&& "on" === $form->getField('saturday-dinner-participate')) {
			$summary['saturday-dinner-participate'] =
				self::getPriceItem('saturday-dinner-participate', $pricing, $discountPricing);
		}

		if ($form->hasField('saturday-party-participate')
				&& "on" === $form->getField('saturday-party-participate')) {
			$summary['saturday-party-participate'] =
				self::getPriceItem('saturday-party-participate', $pricing, $discountPricing);
		}

		// Initialize totals with keys for each currency
		$total = array_fill_keys(array_keys($summary['admission']->prices), 0);
		if ($discountPricing)
			$totalOriginal = array_fill_keys(array_keys($summary['admission']->prices), 0);

		foreach ($summary as $item) {
			foreach ($item->prices as $currency => $price) {
				$total[$currency] += $price;

				if ($discountPricing) {
					$totalOriginal[$currency] +=
						property_exists($item, 'pricesOriginal')
						? $item->pricesOriginal[$currency]
						: $price;
				}
			}
		}

		$summary['total'] = $total;
		if ($summary['discounted'] = (bool)$discountPricing)
			$summary['totalOriginal'] = $totalOriginal;

		return $summary;
	}

	/**
	 * Produce the pricing item based on official pricing, combined with the
	 * optional discounted pricing, coming usually from a discount code. Will
	 * return a structure where the `pricing` field is always the one to use
	 * for payment, and if an item is discounted, there will be a separate
	 * `pricesOriginal` field with the original pricing for the item.
	 *
	 * @param $name the name of the item to fetch pricing for
	 * @param $officialPricing array with official pricing for all items
	 * @param discountPricing optional array with discounted pricing for some or
	 * all items
	 * @return stdClass with the item's pricing, actual and possibly original
	 * if the item was discounted
	 */
	private static function getPriceItem(
			$name,
			array &$officialPricing,
			array &$discountPricing = null
			) {
		$item = $officialPricing[$name];

		if ($item->discounted = (
					$discountPricing && isset($discountPricing[$name])
				)) {
			$item->pricesOriginal = $item->prices;
			$item->prices = $discountPricing[$name]->prices;
		}

		return $item;
	}

	/**
	 * Retrieves pricing details from the database, for a given moment in time.
	 * Accounts for some prices being time-sensitive, ie. changing over time.
	 *
	 * @param time optional time to return prices for. Default is now.
	 * @return pricing structure with all available options and variants.
	 */
	function fetchPricing($time = null) {
		if (!$time) $time = time();

		$query = 'SELECT pi.id_pricing_item,
						 pi.item,
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
				'id' => $row['id_pricing_item'],
				'name' => $row['item'],
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
