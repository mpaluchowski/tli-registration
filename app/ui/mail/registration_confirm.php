<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php \F3::get('lang.EmailRegistrationConfirmationSubject', $form->getEmail()) ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body style="margin: 0; padding: 0;">
	<p><?php echo \F3::get('lang.EmailRegistrationConfirmationIntro', $form->getEmail()) ?></p>

	<p><a href="<?php echo $registrationReviewUrl ?>"><?php echo $registrationReviewUrl ?></a></p>

	<p><?php echo \F3::get('lang.EmailRegistrationConfirmationReview') ?></p>

	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2">
				<h2><?php echo \F3::get('lang.PersonalInformationHeader') ?></h2>
			</td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.FullName') ?></th>
			<td><?php echo $form->getField('full-name') ?></td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.Email') ?></th>
			<td><?php echo $form->getEmail() ?></td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.Phone') ?></th>
			<td><?php echo $form->getField('phone') ?></td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.HomeClub') ?></th>
			<td><?php echo $form->getField('home-club') ?></td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.ExecCommmitteePosition') ?></th>
			<td><?php echo \F3::get('lang.ExecCommmitteePosition-' . $form->getField('exec-position')) ?></td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.EducationalAwards') ?></th>
			<td><?php echo $form->hasField('educational-awards') ? $form->getField('educational-awards') : \F3::get('lang.EducationalAwardsNone') ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<h2><?php echo \F3::get('lang.AccommodationHeader') ?></h2>
			</td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.AccommodationWithToastmasters') ?></th>
			<td><?php echo \F3::get('lang.AccommodationWithToastmasters-' . $form->getField('accommodation-with-toastmasters')) ?></td>
		</tr>
	<?php if ($form->hasField('accommodation-on')):
		$accommodationOnOptions = array_map(function ($item) { return \F3::get('lang.AccommodationWithToastmasters-' . $item); }, $form->getField('accommodation-on'));
	?>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.AccommodationWithToastmastersNeededOn') ?></th>
			<td><?php echo implode(", ", $accommodationOnOptions) ?></td>
		</tr>
	<?php endif; ?>
		<tr>
			<td colspan="2">
				<h2><?php echo \F3::get('lang.EventOptionsHeader') ?></h2>
			</td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.EventsTranslator') ?></th>
			<td><?php echo $form->hasField('translator') && "on" === $form->getField('translator') ? \F3::get('lang.Yes') : \F3::get('lang.No') ?></td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.EventsContest') ?></th>
			<td><?php echo $form->hasField('contest-attend') && "on" === $form->getField('contest-attend') ? \F3::get('lang.Yes') : \F3::get('lang.No') ?></td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.EventsFridaySocial') ?></th>
			<td><?php echo $form->hasField('friday-social-event') && "on" === $form->getField('friday-social-event') ? \F3::get('lang.Yes') : \F3::get('lang.No') ?></td>
		</tr>
	<?php if ($form->hasField('lunch-days')) {
		$lunchDaysOptions = array_map(function ($item) { return \F3::get('lang.EventsLunch-' . $item); }, $form->getField('lunch-days'));
	} ?>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.EventsLunch') ?></th>
			<td><?php echo $form->hasField('lunch') && "on" === $form->getField('lunch') ? \F3::get('lang.Yes') . ', ' . implode(", ", $lunchDaysOptions) : \F3::get('lang.No') ?></td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.EventsSaturdayDinner') ?></th>
			<td><?php echo $form->hasField('saturday-dinner-participate') && "on" === $form->getField('saturday-dinner-participate') ? \F3::get('lang.Yes') . ', ' . $form->getField('saturday-dinner-meal') : \F3::get('lang.No') ?></td>
		</tr>
		<tr>
			<th style="text-align: right; padding: 4px 8px 4px 0;"><?php echo \F3::get('lang.EventsSaturdayParty') ?></th>
			<td><?php echo $form->hasField('saturday-party-participate') && "on" === $form->getField('saturday-party-participate') ? \F3::get('lang.Yes') : \F3::get('lang.No') ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<h2><?php echo \F3::get('lang.CommentsHeader') ?></h2>
			</td>
		</tr>
		<tr>
			<td colspan="2"><?php echo $form->hasField('comments') ? $form->getField('comments') : \F3::get('lang.CommentsNone') ?></td>
		</tr>
	</table>
</body>
</html>
