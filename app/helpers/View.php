<?php

namespace helpers;

class View {

	static function getBaseUrl() {
		return \F3::get('SCHEME')
			. '://'
			. $_SERVER['SERVER_NAME'];
	}

	static function getRegistrationStatusLabelClass($status) {
		switch ($status) {
			case 'PENDING_PAYMENT':
				return 'warning';
			case 'PAID':
				return 'success';
			default:
				throw new Exception('Unknown registration status: ' . $status);
				break;
		}
	}

}
