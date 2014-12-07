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

	function parseQueryToCode(array $discountCode) {
		$code = new \models\DiscountCode($discountCode['email']);

		$code->setId($discountCode['id_discount_code']);
		$code->setCode($discountCode['code']);
		$code->setDateCreated($discountCode['date_created']);
		$code->setDateRedeemed($discountCode['date_redeemed']);

		return $code;
	}

	/**
	 * Validates if the code has the required format.
	 *
	 * @param $code code string to validate
	 * @return true if string matches format, false otherwise
	 */
	static function validateCode($code) {
		return null != $code
			&& preg_match('/^[A-Za-z0-9]{13}$/', $code);
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

	function readAllDiscountCodes() {
		$query = 'SELECT dc.id_discount_code,
						 dc.code,
						 dc.email,
						 dc.date_created,
						 dc.date_redeemed
				  FROM ' . \F3::get('db_table_prefix') . 'discount_codes dc
				  ORDER BY dc.email, dc.date_created';
		$result = \F3::get('db')->exec($query);

		$codes = [];
		foreach ($result as $row) {
			$codes[] = $this->parseQueryToCode($row);
		}
		return $codes;
	}

}
