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
<?php echo \View::instance()->render('administration/_audit_log_entries.php') ?>
		</tbody>
	</table>
	</div>

</div>

<?php echo \View::instance()->render('footer.php') ?>
