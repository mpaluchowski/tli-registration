<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<?php
$renderer = \helpers\FormRendererFactory::className();
?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.ReportLunchOrdersHeader') ?></h1>
	</div>

	<p class="text-center"><?php echo \F3::get('lang.ReportUpdated', \helpers\View::formatUnixDateTime(time())) ?></p>

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th><?php echo \F3::get('lang.FullName') ?></th>
					<th><?php echo \F3::get('lang.EventsLunch-saturday') ?></th>
					<th><?php echo \F3::get('lang.EventsLunch-sunday') ?></th>
					<th><?php echo \F3::get('lang.Email') ?></th>
					<th><?php echo \F3::get('lang.Phone') ?></th>
					<th><?php echo \F3::get('lang.RegistrationStatus') ?></th>
				</tr>
			</thead>
			<tbody>
<?php
$counter = 1;
foreach ($data as $registration):
?>
				<tr data-id="<?php echo $registration->getId() ?>">
					<td><?php echo $counter++ ?></td>
					<td><?php echo $renderer::value($registration, 'full-name') ?></td>
					<td <?php if (in_array('saturday', $registration->getField('lunch-days'))): ?> class="success"><?php echo \F3::get('lang.Yes'); else: ?>><?php echo \F3::get('lang.No'); endif; ?></td>
					<td <?php if (in_array('sunday', $registration->getField('lunch-days'))): ?> class="success"><?php echo \F3::get('lang.Yes'); else: ?>><?php echo \F3::get('lang.No'); endif; ?></td>
					<td><a href="mailto:<?php echo $registration->getEmail() ?>"><?php echo $registration->getEmail() ?></a></td>
					<td><a href="callto:<?php echo $registration->getField('phone') ?>"><?php echo $renderer::value($registration, 'phone') ?></a></td>
					<td><span class="label label-<?php echo \helpers\View::getRegistrationStatusLabel($registration->getStatus()) ?>"><?php echo \F3::get('lang.RegistrationStatus-' . $registration->getStatus()) ?></span></td>
				</tr>
<?php endforeach; // Registrations ?>
			</tbody>
		</table>
	</div>
</div>

<?php echo \View::instance()->render('footer.php') ?>
