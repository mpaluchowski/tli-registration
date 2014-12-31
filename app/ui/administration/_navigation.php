<header class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-top">
				<span class="sr-only"><?php echo \F3::get('lang.ToggleNavigation') ?></span>
				<span class="fa fa-bars"></span>
			</button>
		</div>

		<nav id="navbar-collapse-top" class="collapse navbar-collapse" role="navigation">
			<ul class="nav navbar-nav">
				<li<?php if (\F3::get('PATTERN') == \F3::get('ALIASES.admin_registrations_list')) echo ' class="active"'?>><a href="<?php echo \F3::get('ALIASES.admin_registrations_list') ?>"><?php echo \F3::get('lang.AdminNavRegistrations') ?></a></li>
				<li<?php if (\F3::get('PATTERN') == \F3::get('ALIASES.admin_codes')) echo ' class="active"'?>><a href="<?php echo \F3::get('ALIASES.admin_codes') ?>"><?php echo \F3::get('lang.AdminNavCodes') ?></a></li>
				<li<?php if (\F3::get('PATTERN') == \F3::get('ALIASES.admin_stats')) echo ' class="active"'?>><a href="<?php echo \F3::get('ALIASES.admin_stats') ?>"><?php echo \F3::get('lang.AdminNavStatistics') ?></a></li>
				<li class="dropdown<?php if (substr(\F3::get('PATTERN'), 0, strrpos(\F3::get('PATTERN'), '/')) === substr(\F3::get('ALIASES.admin_reports'), 0, strrpos(\F3::get('ALIASES.admin_reports'), '/'))) echo ' active' ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo \F3::get('lang.AdminNavReports') ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo str_replace('@reportName', 'officers_by_club', \F3::hive()['ALIASES']['admin_reports']) ?>"><?php echo \F3::get('lang.AdminNavReportsOfficersByClub') ?></a></li>
						<li><a href="<?php echo str_replace('@reportName', 'officers_by_position', \F3::hive()['ALIASES']['admin_reports']) ?>"><?php echo \F3::get('lang.AdminNavReportsOfficersByPosition') ?></a></li>
						<li role="presentation" class="divider"></li>
						<li><a href="<?php echo str_replace('@reportName', 'accommodation_with_toastmasters', \F3::hive()['ALIASES']['admin_reports']) ?>"><?php echo \F3::get('lang.AdminNavReportsAccommodationWithToastmasters') ?></a></li>
						<li><a href="<?php echo str_replace('@reportName', 'lunch_orders', \F3::hive()['ALIASES']['admin_reports']) ?>"><?php echo \F3::get('lang.AdminNavReportsLunchOrders') ?></a></li>
						<li><a href="<?php echo str_replace('@reportName', 'event_enrollments', \F3::hive()['ALIASES']['admin_reports']) ?>"><?php echo \F3::get('lang.AdminNavReportsEventEnrollments') ?></a></li>
						<li role="presentation" class="divider"></li>
						<li><a href="<?php echo str_replace('@reportName', 'latest_comments', \F3::hive()['ALIASES']['admin_reports']) ?>"><?php echo \F3::get('lang.AdminNavReportsLatestComments') ?></a></li>
					</ul>
				</li>
				<li<?php if (\F3::get('PATTERN') == \F3::get('ALIASES.admin_audit_log')) echo ' class="active"'?>><a href="<?php echo \F3::get('ALIASES.admin_audit_log') ?>"><?php echo \F3::get('lang.AdminNavAuditLog') ?></a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li>
					<p class="navbar-text"><?php echo \F3::get('lang.SignedInAs', $user->fullName) ?></p>
				</li>
				<li>
					<a href="<?php echo \F3::get('ALIASES.admin_logout') ?>">
						<span class="fa fa-sign-out"></span>
						<?php echo \F3::get('lang.LogoutButton') ?>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</header>
