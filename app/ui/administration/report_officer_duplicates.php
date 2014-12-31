<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<?php
$renderer = \helpers\FormRendererFactory::className();
?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.ReportOfficerDuplicatesHeader') ?></h1>
	</div>

	<p class="text-center"><?php echo \F3::get('lang.ReportUpdated', \helpers\View::formatUnixDateTime(time())) ?></p>

	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th><?php echo \F3::get('lang.HomeClub') ?></th>
					<th><?php echo \F3::get('lang.ReportExecCommitteePositionShort') ?></th>
					<th><?php echo \F3::get('lang.FullName') ?></th>
					<th><?php echo \F3::get('lang.Email') ?></th>
					<th><?php echo \F3::get('lang.Phone') ?></th>
					<th><?php echo \F3::get('lang.RegistrationStatus') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($data as $club => $positions):
				$clubFirst = true;
			foreach ($positions as $position => $registrations):
				$positionFirst = true;
			foreach ($registrations as $registration):
			?>
				<tr data-id="<?php echo $registration->getId() ?>">
					<?php if ($clubFirst): ?><td rowspan="<?php echo count($positions, COUNT_RECURSIVE) - count($positions) ?>" style="vertical-align: middle;"><?php echo $club ?></td><?php endif; ?>
					<?php if ($positionFirst): ?><td rowspan="<?php echo count($registrations) ?>" style="vertical-align: middle;"><?php echo \F3::get('lang.ExecCommmitteePositionShort-' . $position) ?></td><?php endif; ?>
					<td><?php echo $renderer::value($registration, 'full-name') ?></td>
					<td><a href="mailto:<?php echo $registration->getEmail() ?>"><?php echo $registration->getEmail() ?></a></td>
					<td><a href="callto:<?php echo $registration->getField('phone') ?>"><?php echo $renderer::value($registration, 'phone') ?></a></td>
					<td><span class="label label-<?php echo \helpers\View::getRegistrationStatusLabel($registration->getStatus()) ?>"><?php echo \F3::get('lang.RegistrationStatus-' . $registration->getStatus()) ?></span></td>
				</tr>
			<?php
				$positionFirst = false;
				$clubFirst = false;
			endforeach; // Registrations
			endforeach; // Positions
			endforeach; // Clubs
			?>
			</tbody>
		</table>
	</div>
</div>

<?php echo \View::instance()->render('footer.php') ?>
