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

		$orderId,
		$method,
		$statement,

		$dateStarted,
		$dateValid,
		$datePaid;

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

	function setOrderId($orderId) {
		$this->orderId = $orderId;
	}

	function getOrderId() {
		return $this->orderId;
	}

	function setMethod($method) {
		$this->method = $method;
	}

	function getMethod() {
		return $this->method;
	}

	function setStatement($statement) {
		$this->statement = $statement;
	}

	function getStatement() {
		return $this->statement;
	}

	function setDateStarted($dateStarted) {
		$this->dateStarted = $dateStarted;
	}

	function getDateStarted() {
		return $this->dateStarted;
	}

	function setDateValid($dateValid) {
		$this->dateValid = $dateValid;
	}

	function getDateValid() {
		return $this->dateValid;
	}

	function setDatePaid($datePaid) {
		$this->datePaid = $datePaid;
	}

	function getDatePaid() {
		return $this->datePaid;
	}

}
