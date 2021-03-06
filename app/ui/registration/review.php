<?php \F3::set('bodyClass', "tli-navigated") ?>

<?php echo \View::instance()->render('header.php') ?>

<?php
$renderer = \helpers\FormRendererFactory::className();
?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.RegistrationReviewHeader', $form->getField('full-name')) ?></h1>
	</div>

	<?php echo \View::instance()->render('message-alerts.php') ?>

	<?php if ('pending-payment' === $form->getStatus()): ?>
	<p><?php echo \F3::get('lang.RegistrationReviewIntro') ?></p>
	<?php endif ?>

	<div class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.RegistrationStatus') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static">
					<span class="label label-<?php echo \helpers\View::getRegistrationStatusLabel($form->getStatus()) ?>"><?php echo \F3::get('lang.RegistrationStatus-' . $form->getStatus()) ?></span>
				</p>
				<p class="form-control-static">
					<?php echo \F3::get('lang.RegistrationStatusInfo-' . $form->getStatus(), [\helpers\View::formatDateTime($form->getDateEntered()), \helpers\View::formatDateTime($form->getDatePaid())]) ?>
				</p>
			</div>
		</div>

		<h2><?php echo \F3::get('lang.PersonalInformationHeader') ?></h2>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.FullName') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'full-name') ?></p>
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
				<p class="form-control-static"><?php echo $renderer::value($form, 'phone') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.Country') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'country') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.HomeClub') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'home-club') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.ExecCommmitteePosition') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'exec-position') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EducationalAwards') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'educational-awards') ?></p>
			</div>
		</div>

		<h2><?php echo \F3::get('lang.AccommodationHeader') ?></h2>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.AccommodationWithToastmasters') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'accommodation-with-toastmasters') ?></p>
			</div>
		</div>
	<?php if ($form->hasField('accommodation-on')):	?>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.AccommodationWithToastmastersNeededOn') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'accommodation-on') ?></p>
			</div>
		</div>
	<?php endif; ?>

		<h2><?php echo \F3::get('lang.EventOptionsHeader') ?></h2>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EventsTranslator') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'translator') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EventsContest') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'contest-attend') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EventsFridayCopernicus') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'friday-copernicus-attend') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EventsFridaySocial') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'friday-social-event') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EventsLunch') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'lunch') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EventsSaturdayDinner') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'saturday-dinner-participate') ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo \F3::get('lang.EventsSaturdayParty') ?></label>
			<div class="col-sm-9">
				<p class="form-control-static"><?php echo $renderer::value($form, 'saturday-party-participate') ?></p>
			</div>
		</div>

		<h2><?php echo \F3::get('lang.CommentsHeader') ?></h2>

		<div class="form-group">
			<div class="col-sm-12">
				<p class="form-control-static"><?php echo $renderer::value($form, 'comments') ?></p>
			</div>
		</div>
	</div>

	<h2><?php echo \F3::get('lang.PaymentBreakdownHeader') ?></h2>

	<p><?php echo \F3::get('lang.PaymentBreakdownIntro-' . $form->getStatus(), \helpers\View::formatDateTime($form->getDatePaid())) ?></p>

	<div class="table-responsive">
		<table class="table tli-currencies-<?php echo count($paymentSummary['total']) ?>">
			<thead>
				<tr>
					<th><?php echo \F3::get('lang.PaymentItemHead') ?></th>
					<th><?php echo \F3::get('lang.PaymentTypeHead') ?></th>
				<?php foreach ($paymentSummary['admission']->prices as $currency => $price): ?>
					<th><?php echo \F3::get('lang.PaymentPriceHead') . ' ' . $currency ?></th>
				<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $renderer::pricing('admission') ?></td>
					<td><?php
					echo $renderer::pricing('admission', $paymentSummary['admission']->variant);
					if ('paid' !== $form->getStatus() && !$paymentSummary['admission']->discounted):
						?> (<?php echo \F3::get('lang.PriceValidThrough', \helpers\View::formatDate($paymentSummary['admission']->dateValidThrough)) ?>)<?php
					endif; ?></td>
				<?php foreach ($paymentSummary['admission']->prices as $currency => $price): ?>
					<td>
						<?php if ($paymentSummary['admission']->discounted): ?>
							<del><?php echo \helpers\CurrencyFormatter::moneyFormat($currency, $paymentSummary['admission']->pricesOriginal[$currency]) ?></del><br>
						<?php endif; ?>
						<?php echo \helpers\CurrencyFormatter::moneyFormat($currency, $price) ?>
					</td>
				<?php endforeach; ?>
				</tr>
			<?php if ($form->hasField('friday-copernicus-attend') && "on" === $form->getField('friday-copernicus-attend')):
			if (in_array('center', $form->getField('friday-copernicus-options'))):
			?>
				<tr>
					<td><?php echo $renderer::pricing('friday-copernicus-attend') ?></td>
					<td><?php echo $renderer::pricing('friday-copernicus-attend', 'center') ?></td>
				<?php foreach ($paymentSummary['friday-copernicus-attend-center']->prices as $currency => $price): ?>
					<td>
						<?php if ($paymentSummary['friday-copernicus-attend-center']->discounted): ?>
							<del><?php echo \helpers\CurrencyFormatter::moneyFormat($currency, $paymentSummary['friday-copernicus-attend-center']->pricesOriginal[$currency]) ?></del><br>
						<?php endif; ?>
						<?php echo  \helpers\CurrencyFormatter::moneyFormat($currency, $price) ?>
					</td>
				<?php endforeach; ?>
				</tr>
			<?php endif;
			if (in_array('planetarium', $form->getField('friday-copernicus-options'))):
			?>
				<tr>
					<td><?php echo $renderer::pricing('friday-copernicus-attend') ?></td>
					<td><?php echo $renderer::pricing('friday-copernicus-attend', 'planetarium') ?></td>
				<?php foreach ($paymentSummary['friday-copernicus-attend-planetarium']->prices as $currency => $price): ?>
					<td>
						<?php if ($paymentSummary['friday-copernicus-attend-planetarium']->discounted): ?>
							<del><?php echo \helpers\CurrencyFormatter::moneyFormat($currency, $paymentSummary['friday-copernicus-attend-planetarium']->pricesOriginal[$currency]) ?></del><br>
						<?php endif; ?>
						<?php echo  \helpers\CurrencyFormatter::moneyFormat($currency, $price) ?>
					</td>
				<?php endforeach; ?>
				</tr>
			<?php endif;
			endif;
			if ($form->hasField('lunch') && "on" === $form->getField('lunch')): ?>
				<tr>
					<td><?php echo $renderer::pricing('lunch') ?></td>
					<td><?php echo $renderer::value($form, 'lunch-days') ?></td>
				<?php foreach ($paymentSummary['lunch']->prices as $currency => $price): ?>
					<td>
						<?php if ($paymentSummary['lunch']->discounted): ?>
							<del><?php echo \helpers\CurrencyFormatter::moneyFormat($currency, $paymentSummary['lunch']->pricesOriginal[$currency]) ?></del><br>
						<?php endif; ?>
						<?php echo  \helpers\CurrencyFormatter::moneyFormat($currency, $price) ?>
					</td>
				<?php endforeach; ?>
				</tr>
			<?php endif;
			if ($form->hasField('saturday-dinner-participate') && "on" === $form->getField('saturday-dinner-participate')): ?>
				<tr>
					<td><?php echo $renderer::pricing('saturday-dinner-participate') ?></td>
					<td><?php echo \F3::get('lang.EventsSaturdayDinner-' . $form->getField('saturday-dinner-meal')) ?></td>
				<?php foreach ($paymentSummary['saturday-dinner-participate']->prices as $currency => $price): ?>
					<td>
						<?php if ($paymentSummary['saturday-dinner-participate']->discounted): ?>
							<del><?php echo \helpers\CurrencyFormatter::moneyFormat($currency, $paymentSummary['saturday-dinner-participate']->pricesOriginal[$currency]) ?></del><br>
						<?php endif; ?>
						<?php echo  \helpers\CurrencyFormatter::moneyFormat($currency, $price) ?>
					</td>
				<?php endforeach; ?>
				</tr>
			<?php endif;
			if ($form->hasField('saturday-party-participate') && "on" === $form->getField('saturday-party-participate')): ?>
				<tr>
					<td><?php echo $renderer::pricing('saturday-party-participate') ?></td>
					<td><?php echo $paymentSummary['saturday-party-participate']->variant ? $paymentSummary['saturday-party-participate']->variant : '&mdash;' ?></td>
				<?php foreach ($paymentSummary['saturday-party-participate']->prices as $currency => $price): ?>
					<td>
						<?php if ($paymentSummary['saturday-party-participate']->discounted): ?>
							<del><?php echo \helpers\CurrencyFormatter::moneyFormat($currency, $paymentSummary['saturday-party-participate']->pricesOriginal[$currency]) ?></del><br>
						<?php endif; ?>
						<?php echo  \helpers\CurrencyFormatter::moneyFormat($currency, $price) ?>
					</td>
				<?php endforeach; ?>
				</tr>
			<?php endif; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2" class="text-right"><?php echo \F3::get('lang.PaymentTotal') ?></td>
				<?php foreach ($paymentSummary['total'] as $currency => $price): ?>
					<th>
						<?php if ($paymentSummary['discounted']): ?>
						<del><?php echo \helpers\CurrencyFormatter::moneyFormat($currency, $paymentSummary['totalOriginal'][$currency]) ?></del><br>
						<?php endif; ?>
						<?php echo  \helpers\CurrencyFormatter::moneyFormat($currency, $price) ?>
					</th>
				<?php endforeach; ?>
				</tr>
			</tfoot>
		</table>
	</div>

<?php if ('pending-payment' === $form->getStatus()): ?>
	<?php if (!$paymentSummary['discounted']): ?>
	<form action="<?php echo \F3::get('ALIASES.registration_code_redeem') ?>" method="POST" style="margin-bottom: 3em;">
		<label for="discount-code" class="sr-only"><?php echo \F3::get('lang.DiscountCode') ?></label>
		<p class="help-block"><?php echo \F3::get('lang.DiscountCodeHelp') ?></p>

		<div class="input-group" style="max-width: 400px;">
			<input type="text" id="discount-code" name="discount-code" placeholder="ABCDEF1234567" required pattern="^[A-Za-z0-9]{13}$" title="<?php echo \F3::get('lang.DiscountCodeTitle') ?>" class="form-control">
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default"><?php echo \F3::get('lang.DiscountCodeRedeemButton') ?></button>
			</span>
		</div>

		<input type="hidden" name="registrationId" value="<?php echo $form->getId() ?>">
	</form>
	<?php endif; ?>

	<?php
		$processorClass = \models\PaymentProcessorFactory::className();
		if ($processorClass::isTestMode()):
	?>
	<div class="alert alert-warning" role="alert"><?php echo \F3::get('lang.PaymentTestModeActiveAlert') ?></div>
	<?php endif; ?>

	<a href="<?php echo \F3::get('ALIASES.payment_pay') ?>" class="btn btn-lg btn-success"><?php echo \F3::get('lang.SelectPaymentOptionButton') ?></a>
<?php endif; ?>
</div>

<?php echo \View::instance()->render('_navigation.php') ?>

<?php echo \View::instance()->render('footer.php') ?>
