<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<?php
$renderer = \helpers\FormRendererFactory::className();
?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.ReportWaitingListHeader') ?></h1>
	</div>

	<p class="text-center"><?php echo \F3::get('lang.ReportUpdated', \helpers\View::formatUnixDateTime(time())) ?></p>

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th><?php echo \F3::get('lang.FullName') ?></th>
					<th><?php echo \F3::get('lang.HomeClub') ?></th>
					<th><?php echo \F3::get('lang.ReportExecCommitteePositionShort') ?></th>
					<th><?php echo \F3::get('lang.Email') ?></th>
					<th><?php echo \F3::get('lang.Phone') ?></th>
					<th><?php echo \F3::get('lang.DateEntered') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($data as $registration): ?>
				<tr data-id="<?php echo $registration->getId() ?>">
					<td><?php echo $renderer::value($registration, 'full-name') ?></td>
					<td<?php if ("None" !== $registration->getField('home-club')): ?> class="success"<?php endif; ?>><?php echo $renderer::value($registration, 'home-club') ?></td>
					<td<?php if ("none" !== $registration->getField('exec-position')): ?> class="success"<?php endif; ?>><?php echo \F3::get('lang.ExecCommmitteePositionShort-' . $registration->getField('exec-position')) ?></td>
					<td><a href="mailto:<?php echo $registration->getEmail() ?>"><?php echo $registration->getEmail() ?></a></td>
					<td><a href="callto:<?php echo $registration->getField('phone') ?>"><?php echo $renderer::value($registration, 'phone') ?></a></td>
					<td><?php echo \helpers\View::formatDateTime($registration->getDateEntered()) ?></td>
				</tr>
			<?php endforeach; // Registrations ?>
			</tbody>
		</table>
	</div>
</div>

<?php echo \View::instance()->render('footer.php') ?>
