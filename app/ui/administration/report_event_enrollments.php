<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<?php
$renderer = \helpers\FormRendererFactory::className();
?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.ReportEventEnrollmentsHeader') ?></h1>
	</div>

	<p class="text-center"><?php echo \F3::get('lang.ReportUpdated', \helpers\View::formatUnixDateTime(time())) ?></p>

<?php foreach ($data as $event => $registrations): ?>
	<h2><?php echo \F3::get('lang.ReportEventEnrollmentsHeader-' . $event) ?></h2>

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th><?php echo \F3::get('lang.FullName') ?></th>
				<?php if ('saturday-dinner-participate' === $event): ?>
					<th><?php echo \F3::get('lang.EventsSaturdayDinnerMeal') ?></th>
				<?php endif; ?>
					<th><?php echo \F3::get('lang.Email') ?></th>
					<th><?php echo \F3::get('lang.Phone') ?></th>
					<th><?php echo \F3::get('lang.RegistrationStatus') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$counter = 1;
			foreach ($registrations as $registration):
			?>
				<tr data-id="<?php echo $registration->getId() ?>">
					<td><?php echo $counter++ ?></td>
					<td><?php echo $renderer::value($registration, 'full-name') ?></td>
				<?php if ('saturday-dinner-participate' === $event): ?>
					<td><?php echo $renderer::value($registration, 'saturday-dinner-meal') ?></td>
				<?php endif; ?>
					<td><a href="mailto:<?php echo $registration->getEmail() ?>"><?php echo $registration->getEmail() ?></a></td>
					<td><a href="callto:<?php echo $registration->getField('phone') ?>"><?php echo $renderer::value($registration, 'phone') ?></a></td>
					<td><span class="label label-<?php echo \helpers\View::getRegistrationStatusLabel($registration->getStatus()) ?>"><?php echo \F3::get('lang.RegistrationStatus-' . $registration->getStatus()) ?></span></td>
				</tr>
			<?php endforeach; // Registrations ?>
			</tbody>
		</table>
	</div>
<?php endforeach; // Events ?>
</div>

<?php echo \View::instance()->render('footer.php') ?>
