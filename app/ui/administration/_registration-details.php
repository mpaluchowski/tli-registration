<?php
$renderer = \helpers\FormRendererFactory::className();
?>

<div class="container-fluid">
<div class="row">
	<div class="col-sm-6">
		<table class="tli-table-registration-details">
			<tbody>
				<tr>
					<td colspan="2">
						<h4><?php echo \F3::get('lang.PersonalInformationHeader') ?></h4>
					</td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.Country') ?></th>
					<td><?php echo $renderer::value($form, 'country') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.HomeClub') ?></th>
					<td><?php echo $renderer::value($form, 'home-club') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.ExecCommmitteePosition') ?></th>
					<td><?php echo $renderer::value($form, 'exec-position') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EducationalAwards') ?></th>
					<td><?php echo $renderer::value($form, 'educational-awards') ?></td>
				</tr>
				<tr>
					<td colspan="2">
						<h4><?php echo \F3::get('lang.AccommodationHeader') ?></h4>
					</td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.AccommodationWithToastmasters') ?></th>
					<td><?php echo $renderer::value($form, 'accommodation-with-toastmasters') ?></td>
				</tr>
			<?php if ($form->hasField('accommodation-on')): ?>
				<tr>
					<th><?php echo \F3::get('lang.AccommodationWithToastmastersNeededOn') ?></th>
					<td><?php echo $renderer::value($form, 'accommodation-on') ?></td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	</div>

	<div class="col-sm-6">
		<table class="tli-table-registration-details">
			<tbody>
				<tr>
					<td colspan="2">
						<h4><?php echo \F3::get('lang.EventOptionsHeader') ?></h4>
					</td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsTranslator') ?></th>
					<td><?php echo $renderer::value($form, 'translator') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsContest') ?></th>
					<td><?php echo $renderer::value($form, 'contest-attend') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsFridayCopernicus') ?></th>
					<td><?php echo $renderer::value($form, 'friday-copernicus-attend') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsFridaySocial') ?></th>
					<td><?php echo $renderer::value($form, 'friday-social-event') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsLunch') ?></th>
					<td><?php echo $renderer::value($form, 'lunch') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsSaturdayDinner') ?></th>
					<td><?php echo $renderer::value($form, 'saturday-dinner-participate') ?></td>
				</tr>
				<tr>
					<th><?php echo \F3::get('lang.EventsSaturdayParty') ?></th>
					<td><?php echo $renderer::value($form, 'saturday-party-participate') ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<h4><?php echo \F3::get('lang.CommentsHeader') ?></h4>

		<p><?php echo $renderer::value($form, 'comments') ?></p>
	</div>
</div>
</div>
