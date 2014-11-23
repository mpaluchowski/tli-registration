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
	 * @return currently loaded language of application.
	 */
	static function getCurrentLanguage() {
		return explode("-", explode(",", \F3::get('LANGUAGE'))[0])[0];
	}

	/**
	 * Produces the label type to display for each registration status.
	 *
	 * @param status Registration status to provide a label for.
	 * @param color When true, returns the color of the label, instead of class.
	 * @return class name to use for the label for given status.
	 * @throws exception when status provided isn't supported.
	 */
	static function getRegistrationStatusLabel($status, $color = false) {
		switch ($status) {
			case 'PENDING_PAYMENT':
			case 'PROCESSING_PAYMENT':
				return $color ? '#f0ad4e' : 'warning';
			case 'PAID':
				return $color ? '#5cb85c' : 'success';
			case 'WAITING_LIST':
			case 'PENDING_REVIEW':
				return $color ? '#777' : 'default';
			default:
				throw new Exception('Unknown registration status: ' . $status);
		}
	}

}
