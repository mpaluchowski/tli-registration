<?php

namespace models;

class DiscountCodeDao {

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

	function parseRequestToCode(array $postValues) {
		$code = new \models\DiscountCode($postValues['email']);

		foreach ($postValues['pricing-items'] as $itemId) {
			foreach ($postValues['price'][$itemId] as $currency => $price) {
				$code->setPricingItem($itemId, $currency, $price);
			}
		}

		return $code;
	}

	function generateCode() {
		return strtoupper(uniqid());
	}

	function saveDiscountCode(\models\DiscountCode $code) {
		\F3::get('db')->begin();

		$query = 'INSERT INTO ' . \F3::get('db_table_prefix') . 'discount_codes (
				code,
				email,
				date_created
			) VALUES (
				:code,
				:email,
				NOW()
			)';
		\F3::get('db')->exec($query, [
			'code' => $code->getCode() ?: $this->generateCode(),
			'email' => $code->getEmail(),
			]);

		$codeId = \F3::get('db')->lastInsertID();

		$query = 'INSERT INTO ' . \F3::get('db_table_prefix') . 'rel_discount_codes_pricing_items (
				fk_discount_code,
				fk_pricing_item,
				currency,
				price
			) VALUES (
				:discountCodeId,
				:pricingItemId,
				:currency,
				:price
			)';
		$st = \F3::get('db')->prepare($query);

		foreach ($code->getPricingItems() as $itemId => $prices) {
			foreach ($prices as $currency => $price) {
				$st->execute([
					'discountCodeId' => $codeId,
					'pricingItemId' => $itemId,
					'currency' => $currency,
					'price' => $price,
					]);
			}
		}

		\F3::get('db')->commit();

		return $codeId;
	}

}
