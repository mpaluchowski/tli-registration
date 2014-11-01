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

	function calculateSummary(\models\RegistrationForm $form) {
		$pricing = $this->fetchPricing();

		$summary = [
			'admission' => $pricing['admission'],
		];

		if ($form->hasField('friday-social-event')
				&& "on" === $form->getField('friday-social-event')) {
			$summary['friday-social-event'] = $pricing['friday-social-event'];
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

		$total = 0;
		foreach ($summary as $item) {
			$total += $item->price;
		}
		$summary['total'] = $total;

		return $summary;
	}

	private function fetchPricing($time = null) {
		if (!$time) $time = time();

		$query = 'SELECT pi.item,
						 pi.variant,
						 pi.date_valid_through,
						 pp.price
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
				  ';
		$rows = \F3::get('db')->exec($query, [
				'datetime' => $time
			]);

		$pricing = [];
		foreach ($rows as $row) {
			$pricing[$row['item'] . ($row['item'] != 'admission' && $row['variant'] ? '-' . $row['variant'] : '')] = (object)[
				'variant' => $row['variant'],
				'dateValidThrough' => $row['date_valid_through'],
				'price' => $row['price'],
			];
		}
		return $pricing;
	}

}
