<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.AuditLogHeader') ?></h1>
	</div>

	<div class="table-responsive">
	<table id="audit-log-table" class="table table-hover tli-table-gravatar" data-paging-url="<?php echo \F3::get('ALIASES.admin_audit_log_load_page') ?>">
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

	<a id="audit-log-load-btn" href="#" class="btn btn-default"><?php echo \F3::get('lang.AuditLogLoadOlder') ?></a>

</div>

<script src="/js/audit-log.js"></script>
<script>
  (function() {
    tliRegister.auditLog.init();
  })();
</script>

<?php echo \View::instance()->render('footer.php') ?>
