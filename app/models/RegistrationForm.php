<?php

namespace models;

class RegistrationForm {

	private $id;
	private $email;
	private $isWaitingList;
	private $dateEntered;
	private $datePaid;
	private $fields = [];

	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}

	function getStatus() {
		if ($this->isWaitingList)
			return 'WAITING_LIST';
		if (!$this->datePaid)
			return 'PENDING_PAYMENT';
		if ($this->datePaid)
			return 'PAID';
	}

	function getEmail() {
		return $this->email;
	}

	function setEmail($email) {
		$this->email = $email;
	}

	function setWaitingList($isWaitingList) {
		$this->isWaitingList = $isWaitingList;
	}

	function isWaitingList() {
		return $this->isWaitingList;
	}

	function getDateEntered() {
		return $this->dateEntered;
	}

	function setDateEntered($dateEntered) {
		$this->dateEntered = $dateEntered;
	}

	function getDatePaid() {
		return $this->datePaid;
	}

	function setDatePaid($datePaid) {
		$this->datePaid = $datePaid;
	}

	function getFields() {
		return $this->fields;
	}

	function hasField($key) {
		return array_key_exists($key, $this->fields);
	}

	function getField($key) {
		return $this->fields[$key];
	}

	function setField($key, $value) {
		$this->fields[$key] = $value;
	}

	function clearField($key) {
		unset($this->fields[$key]);
	}

	function getHash() {
		return sha1($this->email);
	}

}
