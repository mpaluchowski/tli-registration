<?php

namespace models;

class DiscountCodeDao {

	function parseRequestToCode(array $postValues) {
		$code = new \models\DiscountCode($postValues['email']);

		foreach ($postValues['pricing-items'] as $itemId) {
			foreach ($postValues['price'][$itemId] as $currency => $price) {
				$code->setPricingItem($itemId, $currency, $price);
			}
		}

		return $code;
	}

}
