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
				<li<?php if (\F3::get('PATTERN') == \F3::get('ALIASES.admin_stats')) echo ' class="active"'?>><a href="<?php echo \F3::get('ALIASES.admin_stats') ?>"><?php echo \F3::get('lang.AdminNavStatistics') ?></a></li>
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
