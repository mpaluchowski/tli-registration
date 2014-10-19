<?php

namespace helpers;

class View {

	static function getBaseUrl() {
		return \F3::get('SCHEME')
			. '://'
			. $_SERVER['SERVER_NAME'];
	}
}
