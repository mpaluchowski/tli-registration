<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.RegistrationsListHeader') ?></h1>
	</div>

	<p><?php echo \F3::get('lang.RegistrationsListIntro', [$stats->count, $stats->registered, $stats->waitingList, $stats->pendingReview, $stats->paid, strftime("%c", strtotime($stats->last))]) ?></p>

	<a href="<?php echo \F3::get('ALIASES.admin_registrations_export_csv') ?>" class="btn btn-default">Download CSV</a>

<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<th style="white-space: nowrap;"><?php echo \F3::get('lang.FullName') ?></th>
			<th style="white-space: nowrap;"><?php echo \F3::get('lang.Email') ?></th>
			<th style="white-space: nowrap;"><?php echo \F3::get('lang.Phone') ?></th>
			<th style="white-space: nowrap;"><?php echo \F3::get('lang.DateEntered') ?></th>
			<th style="white-space: nowrap;"><?php echo \F3::get('lang.DatePaid') ?></th>
			<th style="white-space: nowrap;"><?php echo \F3::get('lang.RegistrationStatus') ?></th>
		</thead>
		<tbody>
	<?php foreach ($registrations as $registration): ?>
			<tr data-id="<?php echo $registration->getId() ?>">
				<td><a href="#" class="registration-details-expander"><?php echo $registration->getField('full-name') ?></a></td>
				<td><a href="mailto:<?php echo $registration->getEmail() ?>"><?php echo $registration->getEmail() ?></a></td>
				<td><a href="callto:<?php echo $registration->getField('phone') ?>"><?php echo $registration->getField('phone') ?></a></td>
				<td><?php echo strftime("%c", strtotime($registration->getDateEntered())) ?></td>
				<td><?php echo $registration->getDatePaid() ? strftime("%c", strtotime($registration->getDatePaid())) : "&mdash;" ?></td>
				<td><span class="label label-<?php echo \helpers\View::getRegistrationStatusLabel($registration->getStatus()) ?>"><?php echo \F3::get('lang.RegistrationStatus-' . $registration->getStatus()) ?></span></td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
</div>
</div>

<script src="/js/registrations-list.js"></script>
<script>
  (function() {
    tliRegister.registrationsList.init();
  })();
</script>


<?php echo \View::instance()->render('footer.php') ?>
