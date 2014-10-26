<?php

namespace models;

class FlashScope {

	static function push($key, $value) {
		\F3::set('SESSION.' . $key, $value);
	}

	static function pop($key) {
		$value = \F3::get('SESSION.' . $key);
		\F3::clear('SESSION.' . $key);
		return $value;
	}

	static function has($key) {
		return \F3::get('SESSION.' . $key);
	}

}
