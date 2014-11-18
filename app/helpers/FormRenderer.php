<?php

namespace helpers;

/**
 * Implements default, canonical renderings of forms and their fields.
 */
interface FormRenderer {

	/**
	 * @return array with fields considered 'main', usually displayed in headers
	 * of registrations
	 */
	static function getMainFields();

	/**
	 * Render the value of a form field.
	 *
	 * @param $form instance of \models\RegistrationForm
	 * @param $field name of field to render
	 * @return string with a rendering of the field's value in the given form
	 */
	static function value(\models\RegistrationForm &$form, $field);

}
