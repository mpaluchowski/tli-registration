<?php

namespace helpers;

class FormValidatorImpl implements FormValidator {

	/**
	 * @see \helpers\FormValidator#validateOnSubmit($form)
	 */
	static function validateOnSubmit(\models\RegistrationForm $form) {
		$messages = [];

		if (!$form->hasField('full-name')
				|| !$form->getField('full-name')
				|| !strpos($form->getField('full-name'), " ")) {
			$messages['full-name'] = \F3::get('lang.FullNameValidationMsg');
		}

		// Must provide valid email
		if (!$form->getEmail()
				|| !filter_var($form->getEmail(), FILTER_VALIDATE_EMAIL)) {
			$messages['email'] = \F3::get('lang.EmailValidationMsg');
		}

		// Must provide phone number, at least 9 characters
		if (!$form->hasField('phone')
				|| !$form->getField('phone')
				|| !preg_match('/^\+?[0-9 \-]{9,}$/', $form->getField('phone'))) {
			$messages['phone'] = \F3::get('lang.PhoneValidationMsg');
		}

		// Must provide the club name if it wasn't on the list to select
		if ($form->getField('home-club') === 'Other'
				&& (!$form->hasField('home-club-custom')
					|| !$form->getField('home-club-custom'))) {
			$messages['home-club-custom'] = \F3::get('lang.HomeClubCustomValidationMsg');
		}

		// If someone's not a member of Toastmasters, they can't hold a position
		// in the Exec Committee
		if ($form->getField('home-club') === 'None'
				&& $form->getField('exec-position') !== 'none') {
			$messages['exec-position'] = \F3::get('lang.ExecCommmitteePositionValidationMsg');
		}

		if ($form->hasField('educational-awards')
				&& $form->getField('educational-awards')
				&& !preg_match('/(?:(?:^|, |,| )(CC|ACB|ACS|ACG|CL|ALB|ALS|DTM))+$/', $form->getField('educational-awards'))) {
			$messages['educational-awards'] = \F3::get('lang.EducationalAwardsValidationMsg');
		}

		if (!$form->hasField('accommodation-with-toastmasters')
				|| !$form->getField('accommodation-with-toastmasters')) {
			$messages['accommodation-with-toastmasters'] = \F3::get('lang.AccommodationWithToastmastersValidationMsg');
		} else if ($form->getfield('accommodation-with-toastmasters') === "stay") {
			if (!$form->hasField('accommodation-on')
					|| !$form->getField('accommodation-on')) {
				$messages['accommodation-on'] = \F3::get('lang.AccommodationWithToastmastersNeededOnValidationMsg');
			}

			if (!$form->hasField('sleep-on')
					|| !$form->getField('sleep-on')) {
				$messages['sleep-on'] = \F3::get('lang.AccommodationWithToastmastersSleepOnValidationMsg');
			}
		}

		// Whoever goes to Saturday dinner, must choose a meal option
		if ($form->hasField('saturday-dinner-participate')
				&& (!$form->hasField('saturday-dinner-meal')
					|| !$form->getField('saturday-dinner-meal'))) {
			$messages['saturday-dinner-meal'] = \F3::get('lang.EventsSaturdayDinnerMealValidationMsg');
		}

		return $messages;
	}

}


