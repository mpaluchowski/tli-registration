<?php

namespace helpers;

class FormValidatorImpl implements FormValidator {

	static function validateOnSubmit(\models\RegistrationForm $form) {
		$messages = [];

		if (!$form->hasField('full-name')
				|| !$form->getField('full-name')
				|| !strpos($form->getField('full-name'), " ")) {
			$messages['full-name'] = "Please provide your full name.";
		}

		if (!$form->getEmail()
			|| !filter_var($form->getEmail(), FILTER_VALIDATE_EMAIL)) {
			$messages['email'] = "Please provide your email address.";
		}

		if (!$form->hasField('phone')
				|| !$form->getField('phone')
				|| !preg_match('/^\+?[0-9 \-]{9,}$/', $form->getField('phone'))) {
			$messages['phone'] = "Please provide a phone number, including the operator code and optionally, the country code. You may use dashes and spaces.";
		}

		if ($form->getField('home-club') === 'Other'
				&& (!$form->hasField('home-club-custom')
					|| !$form->getField('home-club-custom'))) {
			$messages['home-club-custom'] = "Please provide the exact name of your home club, or choose one from the list.";
		}

		if ($form->hasField('educational-awards')
				&& $form->getField('educational-awards')
				&& !preg_match('/(?:(?:^|, |,| )(CC|ACB|ACS|ACG|CL|ALB|ALS|DTM))+$/', $form->getField('educational-awards'))) {
			$messages['educational-awards'] = "Please enter your educational awards from among: CC, ACB, ACS, ACG, CL, ALB, ALS, DTM, separated by comas or slashes.";
		}

		if (!$form->hasField('accommodation-with-toastmasters')
				|| !$form->getField('accommodation-with-toastmasters')) {
			$messages['accommodation-with-toastmasters'] = "Please choose an accommodation option.";
		} else if ($form->getfield('accommodation-with-toastmasters') === "stay") {
			if (!$form->hasField('accommodation-on')
					|| !$form->getField('accommodation-on')) {
				$messages['accommodation-on'] = "Please choose the day or days you'll need accommodation on.";
			}

			if (!$form->hasField('sleep-on')
					|| !$form->getField('sleep-on')) {
				$messages['sleep-on'] = "Please choose your sleeping surface preferences.";
			}
		}

		return $messages;
	}

}


