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

	/**
	 * Parses an array of HTTP request values into a DiscountCode object.
	 *
	 * @param $postValues array with request values, including those to build
	 * a DiscountCode object
	 * @return an instance of DiscountCode filled in with supplied values
	 */
	function parseRequestToCode(array $postValues) {
		$code = new \models\DiscountCode($postValues['email']);

		if (isset($postValues['pricing-items'])) {
			foreach ($postValues['pricing-items'] as $itemName => $itemId) {
				foreach ($postValues['price'][$itemId] as $currency => $price) {
					$code->setPricingItem($itemName, $itemId, $currency, $price);
				}
			}
		}

		return $code;
	}

	/**
	 * Parses a database discount_code row into an instance of DiscountCode.
	 *
	 * @param $discountCode a database row with discount code data
	 * @return an instance of DiscountCode filled in with supplied values
	 */
	function parseQueryToCode(array $discountCode) {
		$code = new \models\DiscountCode($discountCode['email']);

		$code->setId($discountCode['id_discount_code']);
		$code->setCode($discountCode['code']);
		$code->setDateCreated($discountCode['date_created']);
		$code->setDateRedeemed($discountCode['date_redeemed']);

		return $code;
	}

	/**
	 * Validate the correctnes of data stored in a DiscountCode instance.
	 *
	 * @param $code an instance of DiscountCode to validate
	 * @return an array with messages, one for each failed valiation, or empty
	 * array if no errors were found
	 */
	function validateDiscountCode(\models\DiscountCode $code) {
		$messages = [];

		// Must provide valid email
		if (!$code->getEmail()
				|| !filter_var($code->getEmail(), FILTER_VALIDATE_EMAIL)) {
			$messages['email'] = \F3::get('lang.CodesEmailValidationMsg');
		}

		// Must choose at least one pricing item
		if (0 === count($code->getPricingItems())) {
			$messages['pricing-items'] = \F3::get('lang.CodesPricingItemsValidationMsg');
		}

		$priceCalculator = \models\PriceCalculatorFactory::newInstance();
		$pricingItems = $priceCalculator->fetchPricing();

		// No set price can be lower than 0 or higher than original value
		foreach ($code->getPricingItems() as $name => $item) {
			foreach ($item['prices'] as $currency => $price) {
				if ($pricingItems[$name]->prices[$currency] < $price
						|| $price < 0) {
					$messages[$name][$currency] = \F3::get(
						'lang.CodesPricingItemValueValidationMsg',
						[
							$pricingItems[$name]->prices[$currency],
							$currency,
						]
						);
				}
			}
		}

		return $messages;
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

	/**
	 * Generates the discount code, unique for most practical purposes.
	 *
	 * @return returns a 13-character, unique discount code.
	 */
	function generateCode() {
		return strtoupper(substr(md5(microtime()), 0, 13));
	}

	/**
	 * Saves a new Discount Code in the database. Will amend the supplied
	 * DiscountCode instance with generated data.
	 *
	 * @param $code instance of \models\DiscountCode with data to store
	 * @return ID of the newly saved Discount Code
	 */
	function saveDiscountCode(\models\DiscountCode &$code) {
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
			'code' => $codeValue = $code->getCode() ?: $this->generateCode(),
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

		foreach ($code->getPricingItems() as $itemName => $item) {
			foreach ($item['prices'] as $currency => $price) {
				$st->execute([
					'discountCodeId' => $codeId,
					'pricingItemId' => $item['id'],
					'currency' => $currency,
					'price' => $price,
					]);
			}
		}

		\F3::get('db')->commit();

		$code->setId($codeId);
		$code->setCode($codeValue);

		return $codeId;
	}

	/**
	 * Redeem a code by linking it to a specific Registration and setting its
	 * redeeming date.
	 *
	 * @param codeId ID of the code to redeem
	 * @param registrationId ID of the Registration to attach the code to
	 * @return true if redeeming succeeded
	 */
	function redeemCode($codeId, $registrationId) {
		$query = 'UPDATE ' . \F3::get('db_table_prefix') . 'discount_codes
				  SET fk_registration = :registrationId,
					  date_redeemed = NOW()
				  WHERE id_discount_code = :codeId';
		\F3::get('db')->exec($query, [
			'registrationId' => $registrationId,
			'codeId' => $codeId,
			]);

		return true;
	}

	/**
	 * Find a non-previously-redeemed code for a given code string and email.
	 *
	 * @param code the code string to look for
	 * @param email email to find code for
	 * @return DiscountCode instance or null of particular arguments not found
	 * or the code is already redeemed.
	 */
	function readDiscountCodeByCodeEmail($code, $email) {
		$query = 'SELECT dc.id_discount_code,
						 dc.code,
						 dc.email,
						 dc.date_created,
						 dc.date_redeemed
				  FROM ' . \F3::get('db_table_prefix') . 'discount_codes dc
				  WHERE dc.code = :code
				    AND dc.email = :email
				    AND dc.date_redeemed IS NULL';
		$result = \F3::get('db')->exec($query, [
			'code' => $code,
			'email' => $email,
			]);

		return $result
			? $this->parseQueryToCode($result[0])
			: null;
	}

	/**
	 * Find discounts for a Registration ID.
	 *
	 * @param $registrationId ID of a Registration tuple
	 * @return Discounts assigned for the given Registration, or empty array, if
	 * no discounts found.
	 */
	function readDiscountsByRegistrationId($registrationId) {
		$query = 'SELECT pi.item,
						 pi.variant,
						 GROUP_CONCAT(CONCAT(rdcpi.currency, ";", rdcpi.price) ORDER BY rdcpi.currency SEPARATOR "|") AS prices
				  FROM ' . \F3::get('db_table_prefix') . 'pricing_items pi
				  JOIN ' . \F3::get('db_table_prefix') . 'rel_discount_codes_pricing_items rdcpi
					ON pi.id_pricing_item = rdcpi.fk_pricing_item
				  JOIN ' . \F3::get('db_table_prefix') . 'discount_codes dc
					ON dc.id_discount_code = rdcpi.fk_discount_code
				  WHERE dc.fk_registration = :registrationId
				  GROUP BY pi.id_pricing_item';
		$result = \F3::get('db')->exec($query, [
				'registrationId' => $registrationId
			]);

		$pricing = [];
		foreach ($result as $row) {
			$pricing[$row['item'] . ($row['item'] != 'admission' && $row['variant'] ? '-' . $row['variant'] : '')] = (object)[
				'name' => $row['item'],
				'variant' => $row['variant'],
				'prices' => $this->explodePrices($row['prices']),
			];
		}
		return $pricing;
	}

	/**
	 * Retrieve all discount codes in the database.
	 *
	 * @return array of all DiscountCode entities
	 */
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
