<?php

namespace models;

class FlashScope {

	static function push($key, $value) {
		\F3::set('SESSION.flash.' . $key, $value);
	}

	static function pop($key) {
		$value = \F3::get('SESSION.flash.' . $key);
		\F3::clear('SESSION.flash.' . $key);
		return $value;
	}

	static function has($key) {
		return (bool)\F3::get('SESSION.flash.' . $key);
	}

}
