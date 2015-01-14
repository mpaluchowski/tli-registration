<?php

namespace helpers;

class FormProcessorImpl implements \helpers\FormProcessor {

	/**
	 * @see \helpers\FormProcessor#processOnSubmit($form)
	 */
	static function processOnSubmit(\models\RegistrationForm &$form) {
		// Make sure full name case is correct. Some people enter weird things
		// like ALL CAPS strings.
		$form->setField(
			'full-name',
			self::normalizeName($form->getField('full-name'))
			);

		// Registrations from outside Poland and Toastmasters are put on hold
		// for review
		if ('outside' == $form->getField('country')
				|| 'None' == $form->getField('home-club')) {
			$form->setStatus('pending-review');
		}

		// Adjust options for accommodation with toastmasters to match original
		// format, before hosting someone became a sub-option
		if ($form->hasField('accommodation-with-toastmasters-host')
				&& 'host' == $form->getField('accommodation-with-toastmasters-host')) {
			$form->setField('accommodation-with-toastmasters', 'host');
			$form->clearField('accommodation-with-toastmasters-host');
		}

		if ('dont-need' == $form->getField('accommodation-with-toastmasters')) {
			$form->setField('accommodation-with-toastmasters', 'independent');
		}

		// Check if a custom club name was entered
		if ($form->hasField('home-club-custom')
				&& $form->getField('home-club-custom')) {

			$club = self::normalizeName($form->getField('home-club-custom'));

			$dictionaryDao = new \models\DictionaryDao();
			$dictionaryDao->createClub($club);

			$form->setField('home-club', $club);
			$form->clearField('home-club-custom');
		}

		// We don't need to store the consent field
		if ($form->hasField('data-collection-consent')) {
			$form->clearField('data-collection-consent');
		}

		// Remove any events, which are not available anymore
		if ($form->hasField('friday-copernicus-attend'))
			$form->clearField('friday-copernicus-attend');
		if ($form->hasField('friday-copernicus-options'))
			$form->clearField('friday-copernicus-options');
		if ($form->hasField('friday-social-event'))
			$form->clearField('friday-social-event');
		if ($form->hasField('saturday-dinner-participate'))
			$form->clearField('saturday-dinner-participate');
		if ($form->hasField('saturday-dinner-meal'))
			$form->clearField('saturday-dinner-meal');
		if ($form->hasField('saturday-party-participate'))
			$form->clearField('saturday-party-participate');
		if ($form->hasField('lunch'))
			$form->clearField('lunch');
		if ($form->hasField('lunch-days'))
			$form->clearField('lunch-days');
	}

	/**
	 * Normalizes the case of a name, by capitalizing the first letter of every
	 * word and leaving the rest lowercase.
	 *
	 * @param $name the name to normalize
	 * @return the name normalized
	 */
	static function normalizeName($name) {
		return mb_convert_case(mb_strtolower($name), MB_CASE_TITLE);
	}

}
