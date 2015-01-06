<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<?php
$renderer = \helpers\FormRendererFactory::className();
?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.RegistrationsListHeader') ?></h1>
	</div>

	<?php echo \View::instance()->render('message-alerts.php') ?>

	<p><?php echo \F3::get('lang.RegistrationsListIntro', [$stats->count, $stats->registered, $stats->waitingList, $stats->pendingReview, $stats->paid, \helpers\View::formatDateTime($stats->last)]) ?></p>

	<a href="<?php echo \F3::get('ALIASES.admin_registrations_export_csv') ?>" class="btn btn-default">Download CSV</a>

<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th style="white-space: nowrap;"><?php echo \F3::get('lang.FullName') ?></th>
				<th style="white-space: nowrap;"><?php echo \F3::get('lang.Email') ?></th>
				<th style="white-space: nowrap;"><?php echo \F3::get('lang.Phone') ?></th>
				<th style="white-space: nowrap;"><?php echo \F3::get('lang.DateEntered') ?></th>
				<th style="white-space: nowrap;"><?php echo \F3::get('lang.DatePaid') ?></th>
				<th style="white-space: nowrap;"><?php echo \F3::get('lang.RegistrationStatus') ?></th>
			</tr>
		</thead>
		<tbody>
	<?php foreach ($registrations as $registration): ?>
			<tr data-id="<?php echo $registration->getId() ?>">
				<td><a href="#" class="registration-details-expander">
					<span class="fa fa-plus-square"></span>
					<?php echo $renderer::value($registration, 'full-name') ?>
				</a></td>
				<td><a href="mailto:<?php echo $registration->getEmail() ?>"><?php echo $registration->getEmail() ?></a></td>
				<td><a href="callto:<?php echo $registration->getField('phone') ?>"><?php echo $renderer::value($registration, 'phone') ?></a></td>
				<td><?php echo \helpers\View::formatDateTime($registration->getDateEntered()) ?></td>
				<td><?php echo $registration->getDatePaid() ? \helpers\View::formatDateTime($registration->getDatePaid()) : "&mdash;" ?></td>
				<td><span data-value="<?php echo $registration->getStatus() ?>" class="tli-status-changer label label-<?php echo \helpers\View::getRegistrationStatusLabel($registration->getStatus()) ?>"><?php echo \F3::get('lang.RegistrationStatus-' . $registration->getStatus()) ?></span></td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
</div>
</div>

<div id="tli-status-menu">
	<form action="<?php echo \F3::get('ALIASES.admin_registration_change_status') ?>" method="POST">
		<div class="form-group">
		<?php foreach (['waiting-list', 'pending-review', 'pending-payment', 'paid', 'cancelled'] as $status): ?>
			<div class="radio">
				<label><input type="radio" name="status" value="<?php echo $status ?>" data-select-away-msg="<?php echo \F3::get('lang.StatusChangeAwayMsg-' . $status) ?>" required> <span class="label label-<?php echo \helpers\View::getRegistrationStatusLabel($status) ?>"><?php echo \F3::get('lang.RegistrationStatus-' . $status) ?></span></label>
			</div>
		<?php endforeach; ?>
		</div>
		<div class="form-group">
			<div class="checkbox">
				<label><input type="checkbox" name="email" checked> <?php echo \F3::get('lang.StatusChangeSendEmail') ?></label>
			</div>
		</div>
		<input type="hidden" name="id" value="">
		<div class="alert alert-warning" style="display: none;"></div>
		<button type="submit" class="btn btn-success"><?php echo \F3::get('lang.StatusChangeButton') ?></button>
		<button type="reset" class="btn btn-default btn-sm"><?php echo \F3::get('lang.CancelButton') ?></button>
	</form>
</div>

<script src="/js/registrations-list.js"></script>
<script>
  (function() {
    tliRegister.registrationsList.init();
  })();
</script>


<?php echo \View::instance()->render('footer.php') ?>
