<div class="container-fluid">
<div class="row">
	<div class="col-sm-6">
		<table class="table-registration-details">
			<tbody>
				<tr>
					<td colspan="2">
						<h4><?php echo \F3::get('lang.PersonalInformationHeader') ?></h4>
					</td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.Country') ?></th>
					<td><?php echo \F3::get('lang.Country-' . $form->getField('country')) ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.HomeClub') ?></th>
					<td><?php echo $form->getField('home-club') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.ExecCommmitteePosition') ?></th>
					<td><?php echo \F3::get('lang.ExecCommmitteePosition-' . $form->getField('exec-position')) ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EducationalAwards') ?></th>
					<td><?php echo $form->hasField('educational-awards') ? $form->getField('educational-awards') : \F3::get('lang.EducationalAwardsNone') ?></td>
				</tr>
				<tr>
					<td colspan="2">
						<h4><?php echo \F3::get('lang.AccommodationHeader') ?></h4>
					</td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.AccommodationWithToastmasters') ?></th>
					<td><?php echo \F3::get('lang.AccommodationWithToastmasters-' . $form->getField('accommodation-with-toastmasters')) ?></td>
				</tr>
			<?php if ($form->hasField('accommodation-on')):
				$accommodationOnOptions = array_map(function ($item) { return \F3::get('lang.AccommodationWithToastmasters-' . $item); }, $form->getField('accommodation-on'));
			?>
				<tr>
					<th><?php echo \F3::get('lang.AccommodationWithToastmastersNeededOn') ?></th>
					<td><?php echo implode(", ", $accommodationOnOptions) ?></td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	</div>

	<div class="col-sm-6">
		<table class="table-registration-details">
			<tbody>
				<tr>
					<td colspan="2">
						<h4><?php echo \F3::get('lang.EventOptionsHeader') ?></h4>
					</td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsTranslator') ?></th>
					<td><?php echo $form->hasField('translator') && "on" === $form->getField('translator') ? \F3::get('lang.Yes') : \F3::get('lang.No') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsContest') ?></th>
					<td><?php echo $form->hasField('contest-attend') && "on" === $form->getField('contest-attend') ? \F3::get('lang.Yes') : \F3::get('lang.No') ?></td>
				</tr>
			<?php if ($form->hasField('friday-copernicus-options')) {
				$copernicusOptions = array_map(function ($item) { return \F3::get('lang.EventsFridayCopernicusAttend-' . $item); }, $form->getField('friday-copernicus-options'));
			} ?>
				<tr>
					<th><?php echo \F3::get('lang.EventsFridayCopernicus') ?></th>
					<td><?php echo $form->hasField('friday-copernicus-attend') && "on" === $form->getField('friday-copernicus-attend') ? \F3::get('lang.Yes') . ', ' . implode(", ", $copernicusOptions) : \F3::get('lang.No') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsFridaySocial') ?></th>
					<td><?php echo $form->hasField('friday-social-event') && "on" === $form->getField('friday-social-event') ? \F3::get('lang.Yes') : \F3::get('lang.No') ?></td>
				</tr>
			<?php if ($form->hasField('lunch-days')) {
				$lunchDaysOptions = array_map(function ($item) { return \F3::get('lang.EventsLunch-' . $item); }, $form->getField('lunch-days'));
			} ?>
				<tr>
					<th><?php echo \F3::get('lang.EventsLunch') ?></th>
					<td><?php echo $form->hasField('lunch') && "on" === $form->getField('lunch') ? \F3::get('lang.Yes') . ', ' . implode(", ", $lunchDaysOptions) : \F3::get('lang.No') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsSaturdayDinner') ?></th>
					<td><?php echo $form->hasField('saturday-dinner-participate') && "on" === $form->getField('saturday-dinner-participate') ? \F3::get('lang.Yes') . ', ' . $form->getField('saturday-dinner-meal') : \F3::get('lang.No') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsSaturdayParty') ?></th>
					<td><?php echo $form->hasField('saturday-party-participate') && "on" === $form->getField('saturday-party-participate') ? \F3::get('lang.Yes') : \F3::get('lang.No') ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<h4><?php echo \F3::get('lang.CommentsHeader') ?></h4>

		<p><?php echo $form->hasField('comments') ? nl2br($form->getField('comments'), false) : \F3::get('lang.CommentsNone') ?></p>
	</div>
</div>
</div>
