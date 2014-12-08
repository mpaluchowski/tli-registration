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
			$form->setStatusValue('pending-review');
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
