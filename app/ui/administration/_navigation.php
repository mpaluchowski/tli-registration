<header class="navbar navbar-default navbar-static-top">
	<div class="container">
		<nav class="collapse navbar-collapse" role="navigation">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<p class="navbar-text"><?php echo \F3::get('lang.SignedInAs', $user->fullName) ?></p>
				</li>
				<li>
					<a href="<?php echo \F3::get('ALIASES.admin_logout') ?>">
						<span class="glyphicon glyphicon-log-out"></span>
						<?php echo \F3::get('lang.LogoutButton') ?>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</header>
