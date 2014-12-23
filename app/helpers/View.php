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
	 * Produces the URL to a Gravatar image for given email.
	 *
	 * @param $email the email addres to produce a Gravatar for
	 * @param $size optional size of image
	 * @return the URL to place, usually inside the SRC attribute of IMG
	 */
	static function getGravatarUrl($email, $size = 30) {
		return "//www.gravatar.com/avatar/"
			. md5($email)
			. "/?s="
			. $size
			. "&amp;d=mm";
	}

	/**
	 * @return date and time string formatted according to locale set.
	 */
	static function formatDateTime($dateTime) {
		return strftime(\F3::get('lang.dateTimeFormat'), strtotime($dateTime));
	}

	/**
	 * @return date string formatted according to locale set.
	 */
	static function formatDate($dateTime) {
		return strftime(\F3::get('lang.dateFormat'), strtotime($dateTime));
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
				throw new \Exception('Unknown registration status: ' . $status);
		}
	}

	/**
	 * Fetch a Toastmasters color value.
	 *
	 * @param name name of the color from the Toastmasters pallette
	 * @return hex value of the color
	 * @throws exception when passed a color that's not in the pallette
	 */
	static function toastmastersColor($name) {
		switch ($name) {
			case 'blue':
				return '#004156';
			case 'yellow':
				return '#F2DF74';
			case 'grey':
				return '#A9B2B1';
			case 'red':
				return '#CD202C';
			case 'crimson':
				return '#772432';
			default:
				throw new \Exception("Color " . $name . " doesn't exist");
		}
	}

}
