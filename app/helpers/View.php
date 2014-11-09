<?php

namespace helpers;

/**
 * Helping methods useful for the views.
 */
class View {

	/**
	 * @return base URL of the application, the hostname.
	 */
	static function getBaseUrl() {
		return \F3::get('SCHEME')
			. '://'
			. $_SERVER['SERVER_NAME'];
	}

	/**
	 * Produces the label type to display for each registration status.
	 *
	 * @param status Registration status to provide a label for.
	 * @return class name to use for the label for given status.
	 * @throws exception when status provided isn't supported.
	 */
	static function getRegistrationStatusLabelClass($status) {
		switch ($status) {
			case 'PENDING_PAYMENT':
				return 'warning';
			case 'PAID':
				return 'success';
			default:
				throw new Exception('Unknown registration status: ' . $status);
		}
	}

}
