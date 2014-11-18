<?php

namespace helpers;

class FormRendererImpl {

	/**
	 * @see \helpers\FormRenderer#Value(\models\RegistrationForm $form, $field)
	 */
	static function value(\models\RegistrationForm $form, $field) {
		switch ($field) {
			case 'full-name':
			case 'email':
			case 'phone':
			case 'home-club':
				return $form->getField($field);

			case 'country':
				return \F3::get('lang.Country-' . $form->getField($field));

			case 'exec-position':
				return \F3::get('lang.ExecCommmitteePosition-' . $form->getField($field));

			case 'educational-awards':
				return $form->hasField($field)
					? $form->getField($field)
					: \F3::get('lang.EducationalAwardsNone');

			case 'accommodation-with-toastmasters':
				return \F3::get('lang.AccommodationWithToastmasters-'
					. $form->getField($field));

			case 'accommodation-on':
				$accommodationOnOptions = array_map(function ($item) {
					return \F3::get('lang.AccommodationWithToastmasters-' . $item);
				}, $form->getField($field));
				return implode(", ", $accommodationOnOptions);

			case 'translator':
			case 'contest-attend':
			case 'friday-social-event':
			case 'saturday-party-participate':
				return $form->hasField($field)
						&& "on" === $form->getField($field)
					? \F3::get('lang.Yes')
					: \F3::get('lang.No');

			case 'friday-copernicus-attend':
				return $form->hasField($field)
						&& "on" === $form->getField($field)
					? \F3::get('lang.Yes') . ', ' . self::value($form, 'friday-copernicus-options')
					: \F3::get('lang.No');

			case 'friday-copernicus-options':
				$copernicusOptions = array_map(function ($item) {
					return \F3::get('lang.EventsFridayCopernicusAttend-' . $item);
				}, $form->getField($field));
				return implode(", ", $copernicusOptions);

			case 'lunch':
				return $form->hasField($field)
						&& "on" === $form->getField($field)
					? \F3::get('lang.Yes') . ', ' . self::value($form, 'lunch-days')
					: \F3::get('lang.No');

			case 'lunch-days':
				$lunchDaysOptions = array_map(function ($item) {
					return \F3::get('lang.EventsLunch-' . $item);
				}, $form->getField($field));
				return implode(", ", $lunchDaysOptions);

			case 'saturday-dinner-participate':
				return $form->hasField('saturday-dinner-participate')
						&& "on" === $form->getField('saturday-dinner-participate')
					? \F3::get('lang.Yes') . ', ' . $form->getField('saturday-dinner-meal')
					: \F3::get('lang.No');

			case 'comments':
				return $form->hasField('comments')
					? nl2br($form->getField('comments'), false)
					: \F3::get('lang.CommentsNone');

			default:
				throw new \Exception("Field $field is not known by this FormRenderer. Please check the field name or amend the implementation.");
		}
	}

}
