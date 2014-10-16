<?php echo \View::instance()->render('header.php') ?>

<div class="container">
	<h1><?php echo \F3::get('lang.RegistrationReviewHeader', $form->getField('full-name')) ?></h1>

	<p><?php echo \F3::get('lang.RegistrationReviewIntro') ?></p>

	<div class="form-horizontal">
		<h2><?php echo \F3::get('lang.PersonalInformationHeader') ?></h2>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.FullName') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $form->getField('full-name') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.Email') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $form->getEmail() ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.Phone') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $form->getField('phone') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.HomeClub') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $form->getField('home-club') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.ExecCommmitteePosition') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo \F3::get('lang.ExecCommmitteePosition-' . $form->getField('exec-position')) ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EducationalAwards') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $form->hasField('educational-awards') ? $form->getField('educational-awards') : \F3::get('lang.EducationalAwardsNone') ?></p>
			</div>
		</div>

		<h2><?php echo \F3::get('lang.AccommodationHeader') ?></h2>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.AccommodationWithToastmasters') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo \F3::get('lang.AccommodationWithToastmasters-' . $form->getField('accommodation-with-toastmasters')) ?></p>
			</div>
		</div>
	<?php if ($form->hasField('accommodation-on')):
		$accommodationOnOptions = array_map(function ($item) { return \F3::get('lang.AccommodationWithToastmasters-' . $item); }, $form->getField('accommodation-on'));
	?>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.AccommodationWithToastmastersNeededOn') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo implode(", ", $accommodationOnOptions) ?></p>
			</div>
		</div>
	<?php endif;
	if ($form->hasField('sleep-on')):
		$sleepOnOptions = array_map(function ($item) { return \F3::get('lang.AccommodationWithToastmastersSleepOn-' . $item); }, $form->getField('sleep-on'));
	?>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.AccommodationWithToastmastersSleepOn') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo implode(", ", $sleepOnOptions) ?></p>
			</div>
		</div>
	<?php endif; ?>

		<h2><?php echo \F3::get('lang.EventsHeader') ?></h2>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EventsFridaySocial') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo "on" === $form->getField('friday-social-event') ? \F3::get('lang.Yes') : \F3::get('lang.No') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EventsSaturdayDinner') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $form->hasField('saturday-dinner-participate') && "on" === $form->getField('saturday-dinner-participate') ? \F3::get('lang.Yes') . ', ' . $form->getField('saturday-dinner-meal') : \F3::get('lang.No') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EventsSaturdayParty') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $form->hasField('saturday-party-participate') && "on" === $form->getField('saturday-party-participate') ? \F3::get('lang.Yes') : \F3::get('lang.No') ?></p>
			</div>
		</div>

		<h2><?php echo \F3::get('lang.CommentsHeader') ?></h2>

		<div class="form-group">
			<div class="col-sm-12">
				<p class="form-control-static"><?php echo $form->hasField('comments') ? $form->getField('comments') : \F3::get('lang.CommentsNone') ?></p>
			</div>
		</div>
	</div>

	<h2><?php echo \F3::get('lang.PaymentBreakdownHeader') ?></h2>

	<p>Based on the options you selected, your total due payment breaks down as follows:</p>

	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th><?php echo \F3::get('lang.PaymentItemHead') ?></th>
					<th><?php echo \F3::get('lang.PaymentTypeHead') ?></th>
					<th><?php echo \F3::get('lang.PaymentPriceHead') ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo \F3::get('lang.Participation') ?></td>
					<td><?php echo \F3::get('lang.TicketEarly') ?></td>
					<td>50zł</td>
				</tr>
			<?php if ($form->hasField('friday-social-event') && "on" === $form->getField('friday-social-event')): ?>
				<tr>
					<td><?php echo \F3::get('lang.EventsFridaySocial') ?></td>
					<td>&mdash;</td>
					<td>30zł</td>
				</tr>
			<?php endif;
			if ($form->hasField('saturday-dinner-participate') && "on" === $form->getField('saturday-dinner-participate')): ?>
				<tr>
					<td><?php echo \F3::get('lang.EventsSaturdayDinner') ?></td>
					<td><?php echo \F3::get('lang.EventsSaturdayDinner-' . $form->getField('saturday-dinner-meal')) ?></td>
					<td>50zł</td>
				</tr>
			<?php endif;
			if ($form->hasField('saturday-party-participate') && "on" === $form->getField('saturday-party-participate')): ?>
				<tr>
					<td><?php echo \F3::get('lang.EventsSaturdayParty') ?></td>
					<td>&mdash;</td>
					<td>30zł</td>
				</tr>
			<?php endif; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2" class="text-right"><?php echo \F3::get('lang.PaymentTotal') ?></td>
					<th>160zł</th>
				</tr>
			</tfoot>
		</table>
	</div>

	<a href="#" class="btn btn-lg btn-success"><?php echo \F3::get('lang.SelectPaymentOptionButton') ?></a>
</div>

<?php echo \View::instance()->render('footer.php') ?>
