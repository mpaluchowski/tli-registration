<?php

namespace models;

/**
 * Localization manager, setting and returning language preferences.
 */
class L11nManager {

	/**
	 * @return currently loaded language of application.
	 */
	static function language() {
		return \F3::get('language_loaded');
	}

	/**
	 * @return array with languages supported by this application.
	 */
	static function languagesSupported() {
		return \F3::get('languages_supported');
	}

	/**
	 * Set a new locale for the application.
	 *
	 * @param locale full locale formatted as <language>_<country>
	 */
	static function setLanguage($language = null) {
		if (!$language)
			$language = self::negotiateLanguage();
		else if (!in_array($language, \F3::get('languages_supported')))
			throw new \Exception("Locale $language is not supported. The ones supported are: " . implode(', ', \F3::get('locales_supported')));

		\F3::set('COOKIE.language', $language);
		\F3::set('LANGUAGE', $language);
		\F3::set('language_loaded', $language);
	}

	/**
	 * Find out what language should be loaded, based on prior user preferences
	 * or browser content negotiation. If either fails, will return the fallback
	 * languag configured in the framework.
	 *
	 * @return language code.
	 */
	protected static function negotiateLanguage() {
		if (\F3::exists('COOKIE.language'))
			return \F3::get('COOKIE.language');

		if (!\F3::exists('HEADERS.Accept-Language'))
			return \F3::get('FALLBACK');

		/* Content negotiation */
		preg_match_all(
			'/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i',
			\F3::get('HEADERS.Accept-Language'),
			$acceptedLangsParse
			);

		if (count($acceptedLangsParse[1])) {
			// create a list like "en" => 0.8
			$acceptedLangs = array_combine(
				preg_replace('/(\w{2})(-\w{2})?/i', '$1', $acceptedLangsParse[1]),
				$acceptedLangsParse[4]
			);

			// set default to 1 for any without q factor
			foreach ($acceptedLangs as $key => $val) {
				if ($val === '') $acceptedLangs[$key] = 1;
			}

			// sort list based on value
			arsort($acceptedLangs, SORT_NUMERIC);
			foreach($acceptedLangs as $key => $val) {
				if (in_array($key, \F3::get('languages_supported'), true)) {
					return $key;
				}
			}
		}

		return \F3::get('FALLBACK');
	}

}
