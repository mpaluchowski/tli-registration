<?php
\F3::set('bodyClass', "tli-signin");
?>

<?php echo \View::instance()->render('header.php') ?>

<div class="container">
	<?php echo \View::instance()->render('message-alerts.php') ?>

<?php if (in_array('database', \F3::get('auths_supported'))): ?>
	<form action="<?php echo \F3::get('ALIASES.admin_login_process') ?>" method="post" class="tli-form-signin" role="form">
		<label for="email" class="sr-only"><?php echo \F3::get('lang.Email') ?></label>
		<input type="email" name="email" id="email"<?php if (isset($email)) echo ' value="' . $email . '"' ?> class="form-control" placeholder="<?php echo \F3::get('lang.Email') ?>" required autofocus>
		<label for="password" class="sr-only"><?php echo \F3::get("lang.Password") ?></label>
		<input type="password" name="password" id="password" class="form-control" placeholder="<?php echo \F3::get("lang.Password") ?>" required>
		<button class="btn btn-lg btn-primary btn-lock" type="submit"><?php echo \F3::get('lang.SignInButton') ?></button>

	</form>
<?php endif; ?>

	<div class="tli-social-signin">
<?php if (in_array('google', \F3::get('auths_supported'))): ?>
		<a href="<?php
		echo 'https://accounts.google.com/o/oauth2/auth?'
			. http_build_query([
				'scope' => 'email',
				'state' => $oauthState,
				'redirect_uri' => \helpers\View::getBaseUrl() . \F3::get('ALIASES.admin_login_process_oauth2'),
				'response_type' => 'code',
				'client_id' => \models\AuthenticationDao::getGoogleClientId()
				])
		?>" class="tli-google">
			<i class="fa fa-google-plus"></i>
			<?php echo \F3::get('lang.SignInGoogle') ?>
		</a>
<?php endif; ?>
	</div>
</div>

<?php echo \View::instance()->render('footer.php') ?>
