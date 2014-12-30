<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<?php
$renderer = \helpers\FormRendererFactory::className();
$positions = ["president", "vpe", "vpm", "vppr", "secretary", "treasurer", "saa"];
?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.ReportOfficersByPositionHeader') ?></h1>
	</div>

	<p class="text-center"><?php echo \F3::get('lang.ReportUpdated', \helpers\View::formatUnixDateTime(time())) ?></p>

<?php foreach ($positions as $position): ?>
	<h2><?php echo \F3::get('lang.ExecCommmitteePositionShort-' . $position) ?></h2>

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th><?php echo \F3::get('lang.FullName') ?></th>
					<th><?php echo \F3::get('lang.HomeClub') ?></th>
					<th><?php echo \F3::get('lang.Email') ?></th>
					<th><?php echo \F3::get('lang.Phone') ?></th>
					<th><?php echo \F3::get('lang.RegistrationStatus') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			if (isset($data[$position])):
			foreach ($data[$position] as $registration):
			?>
				<tr data-id="<?php echo $registration->getId() ?>">
					<td><?php echo $renderer::value($registration, 'full-name') ?></td>
					<td><?php echo $renderer::value($registration, 'home-club') ?></td>
					<td><a href="mailto:<?php echo $registration->getEmail() ?>"><?php echo $registration->getEmail() ?></a></td>
					<td><a href="callto:<?php echo $registration->getField('phone') ?>"><?php echo $renderer::value($registration, 'phone') ?></a></td>
					<td><span class="label label-<?php echo \helpers\View::getRegistrationStatusLabel($registration->getStatus()) ?>"><?php echo \F3::get('lang.RegistrationStatus-' . $registration->getStatus()) ?></span></td>
				</tr>
			<?php
			endforeach;	// Registrations
			endif;
			?>
			</tbody>
		</table>
	</div>
<?php endforeach; // Positions ?>
</div>

<?php echo \View::instance()->render('footer.php') ?>
