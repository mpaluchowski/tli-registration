<?php

namespace models;

class DiscountCode {

	private
		$id,
		$code,
		$email,
		$dateCreated,

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

	function getPricingItems() {
		return $this->pricingItems;
	}

	function setPricingItem($itemId, $currency, $value) {
		$this->pricingItems[$itemId][$currency] = $value;
	}

	function getPricingItem($itemId, $currency = null) {
		if ($currency)
			return $this->pricingItems[$itemId][$currency];
		else
			return $this->pricingItems[$itemId];
	}

}
