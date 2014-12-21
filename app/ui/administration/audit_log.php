<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.AuditLogHeader') ?></h1>
	</div>

	<div class="table-responsive">
	<table class="table table-hover tli-table-gravatar">
		<thead>
			<th><?php echo \F3::get('lang.AuditLogAdminName') ?></th>
			<th><?php echo \F3::get('lang.AuditLogEventName') ?></th>
			<th><?php echo \F3::get('lang.AuditLogEventObject') ?></th>
			<th><?php echo \F3::get('lang.AuditLogEventData') ?></th>
			<th><?php echo \F3::get('lang.AuditLogEventDate') ?></th>
		</thead>
		<tbody>
		<?php foreach ($events as $event): ?>
			<tr data-id="<?php echo $event->id ?>">
				<td class="text-nowrap">
					<img src="<?php echo \helpers\View::getGravatarUrl($event->administratorEmail, 30) ?>" alt="<?php echo $event->administratorName ?>">
					<?php echo $event->administratorName ?>
				</td>
				<td><?php echo $event->name ?></td>
				<td><?php echo $event->objectName ? $event->objectName . '(' . $event->objectId . ')' : "&mdash;" ?></td>
				<td><?php echo $event->data ?: "&mdash;" ?></td>
				<td class="text-nowrap"><?php echo \helpers\View::formatDateTime($event->dateOccurred) ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	</div>

</div>

<?php echo \View::instance()->render('footer.php') ?>
