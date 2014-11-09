<?php

namespace helpers;

class FormProcessorImpl implements \helpers\FormProcessor {

	/**
	 * @see \helpers\FormProcessor#processOnSubmit($form)
	 */
	static function processOnSubmit(\models\RegistrationForm &$form) {
		// Check if a custom club name was entered
		if ($form->hasField('home-club-custom')
				&& $form->getField('home-club-custom')) {
			$dictionaryDao = new \models\DictionaryDao();
			$dictionaryDao->createClub($form->getField('home-club-custom'));

			$form->setField('home-club', $form->getField('home-club-custom'));
			$form->clearField('home-club-custom');
		}

		// We don't need to store the consent field
		if ($form->hasField('data-collection-consent')) {
			$form->clearField('data-collection-consent');
		}
	}

}
