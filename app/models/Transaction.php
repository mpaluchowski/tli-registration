<?php

namespace models;

class Transaction {

	private
		$sessionId,
		$registrationId,
		$amount,
		$currency,
		$description,
		$email,
		$countryCode,

		$dateStarted;

	function __construct($sessionId, $registrationId, $amount, $currency, $description,
			$email, $countryCode) {
		$this->sessionId = $sessionId;
		$this->registrationId = $registrationId;
		$this->amount = $amount;
		$this->currency = $currency;
		$this->description = $description;
		$this->email = $email;
		$this->countryCode = $countryCode;
	}

	function getSessionId() {
		return $this->sessionId;
	}

	function getRegistrationId() {
		return $this->registrationId;
	}

	function getAmount() {
		return $this->amount;
	}

	function getCurrency() {
		return $this->currency;
	}

	function getDescription() {
		return $this->description;
	}

	function getEmail() {
		return $this->email;
	}

	function getCountryCode() {
		return $this->countryCode;
	}

	function setDateStarted($dateStarted) {
		$this->dateStarted = $dateStarted;
	}

	function getDateStarted() {
		return $this->dateStarted;
	}

}
