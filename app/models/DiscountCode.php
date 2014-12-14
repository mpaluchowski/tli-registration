<?php

namespace models;

class DiscountCode {

	private
		$id,
		$code,
		$email,
		$dateCreated,
		$dateRedeemed,

		$pricingItems = [];

	function __construct($email) {
		$this->email = $email;
	}

	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}

	function getCode() {
		return $this->code;
	}

	function setCode($code) {
		$this->code = $code;
	}

	function getEmail() {
		return $this->email;
	}

	function getDateCreated() {
		return $this->dateCreated;
	}

	function setDateCreated($dateCreated) {
		$this->dateCreated = $dateCreated;
	}

	function getDateRedeemed() {
		return $this->dateRedeemed;
	}

	function setDateRedeemed($dateRedeemed) {
		$this->dateRedeemed = $dateRedeemed;
	}

	function getPricingItems() {
		return $this->pricingItems;
	}

	function setPricingItem($itemName, $itemId, $currency, $value) {
		$this->pricingItems[$itemName]["id"] = $itemId;
		$this->pricingItems[$itemName]["prices"][$currency] = $value;
	}

	function getPricingItem($itemName, $currency = null) {
		if ($currency)
			return $this->pricingItems[$itemName]["prices"][$currency];
		else
			return $this->pricingItems[$itemName];
	}

	function hasPricingItem($itemName) {
		return isset($this->pricingItems[$itemName]);
	}

}
