<?php

namespace helpers;

interface FormProcessor {

	/**
	 * Process form right after it was first submitted by the user.
	 *
	 * @param form RegistrationForm instance, passed by reference.
	 */
	static function processOnSubmit(\models\RegistrationForm &$form);

}
