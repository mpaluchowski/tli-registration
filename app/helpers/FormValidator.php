<?php

namespace helpers;

interface FormValidator {

	static function validateOnSubmit(\models\RegistrationForm $form);

}
