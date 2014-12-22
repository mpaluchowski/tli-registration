<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<?php
$renderer = \helpers\FormRendererFactory::className();
$positions = ["president", "vpe", "vpm", "vppr", "secretary", "treasurer", "saa"];
?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.ReportOfficersByClubHeader') ?></h1>
	</div>

<?php foreach ($data as $divisionName => $areas): ?>
	<h2><?php echo $divisionName == 'other' ? \F3::get('lang.DivisionOther') : \F3::get('lang.DivisionName', $divisionName) ?></h2>
<?php foreach ($areas as $areaName => $clubs): ?>
<?php foreach ($clubs as $clubName => $registrations): ?>
	<h3><?php echo $divisionName . $areaName . ' ' . $clubName ?></h3>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<th><?php echo \F3::get('lang.ExecCommmitteePosition') ?></th>
				<th><?php echo \F3::get('lang.FullName') ?></th>
				<th><?php echo \F3::get('lang.RegistrationStatus') ?></th>
			</thead>
			<tbody>
			<?php foreach ($positions as $position): ?>
				<tr>
					<td><?php echo \F3::get('lang.ExecCommmitteePosition-' . $position) ?></td>
				<?php if (isset($registrations[$position])): ?>
					<td><?php echo $renderer::value($registrations[$position], 'full-name') ?></td>
					<td><span class="label label-<?php echo \helpers\View::getRegistrationStatusLabel($registrations[$position]->getStatus()) ?>"><?php echo \F3::get('lang.RegistrationStatus-' . $registrations[$position]->getStatus()) ?></span></td>
				<?php else: ?>
					<td></td>
					<td></td>
				<?php endif; ?>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php endforeach; // Club ?>
<?php endforeach; // Area ?>
<?php endforeach; // Divisions ?>
</div>

<?php echo \View::instance()->render('footer.php') ?>
