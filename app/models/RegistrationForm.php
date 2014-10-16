<?php

namespace models;

class RegistrationForm {

	private $id;
	private $email;
	private $dateEntered;
	private $dateConfirmed;
	private $fields = [];

	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}

	function getEmail() {
		return $this->email;
	}

	function setEmail($email) {
		$this->email = $email;
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

	function getHash() {
		return sha1($this->email);
	}

}
