<?php

namespace models;

/**
 * Helps in passing variables and state between page reloads.
 */
class FlashScope {

	/**
	 * Store a new variable in the scope.
	 *
	 * @param key name to store the variable under.
	 * @param value value to store.
	 */
	static function push($key, $value) {
		\F3::set('SESSION.flash.' . $key, $value);
	}

	/**
	 * Retrieves and deletes a variable fron the scope.
	 *
	 * @param key name of the variable to retrieve.
	 * @return value of the variable or false, of absent.
	 */
	static function pop($key) {
		$value = \F3::get('SESSION.flash.' . $key);
		\F3::clear('SESSION.flash.' . $key);
		return $value;
	}

	/**
	 * Checks if a variable key is stored in the scope.
	 *
	 * @param key name of the variable to find.
	 * @return true|false whether the variable exists in scope.
	 */
	static function has($key) {
		return (bool)\F3::get('SESSION.flash.' . $key);
	}

}
