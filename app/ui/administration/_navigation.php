<header class="navbar navbar-default navbar-static-top">
	<div class="container">
		<nav class="collapse navbar-collapse" role="navigation">
			<ul class="nav navbar-nav">
				<li<?php if (\F3::get('PATTERN') == \F3::get('ALIASES.admin_registrations_list')) echo ' class="active"'?>><a href="<?php echo \F3::get('ALIASES.admin_registrations_list') ?>"><?php echo \F3::get('lang.AdminNavRegistrations') ?></a></li>
				<li<?php if (\F3::get('PATTERN') == \F3::get('ALIASES.admin_stats')) echo ' class="active"'?>><a href="<?php echo \F3::get('ALIASES.admin_stats') ?>"><?php echo \F3::get('lang.AdminNavStatistics') ?></a></li>
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
