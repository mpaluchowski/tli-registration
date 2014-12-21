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

	/**
	 * Render the pricing item. Will output the label to display for the item
	 * or for the item's variant. If name is passed with a null variant,
	 * will output an empty string.
	 *
	 * @param $name the form field name of the item
	 * @param $variant optional variant of the item
	 * @return localized label for the pricing item, or empty string if passed
	 * name with a null variant
	 */
	static function pricing($name, $variant = null);

}
