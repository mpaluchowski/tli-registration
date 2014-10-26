<?php

namespace helpers;

/**
 * Interface for all custom form validators.
 */
interface FormValidator {

	/**
	 * Validate the form right after it was first submitted.
	 *
	 * @param form Instance of \models\RegistrationForm with values entered by
	 * the user.
	 * @return array of validation messages for incorrect fields, or empty array
	 * if validation passed without errors.
	 */
	static function validateOnSubmit(\models\RegistrationForm $form);

}
