<?php
\F3::set('bodyClass', "signin");
?>

<?php echo \View::instance()->render('header.php') ?>

<div class="container signin">
	<form action="<?php echo \F3::get('ALIASES.admin_login_process') ?>" method="post" class="form-signin" role="form">
		<h2 class="form-signin-heading"><?php echo \F3::get('lang.SignInHeader') ?></h2>
		<label for="email" class="sr-only"><?php echo \F3::get('lang.Email') ?></label>
		<input type="email" name="email" id="email" class="form-control" placeholder="<?php echo \F3::get('lang.Email') ?>" required autofocus>
		<label for="password" class="sr-only"><?php echo \F3::get("lang.Password") ?></label>
		<input type="password" name="password" id="password" class="form-control" placeholder="<?php echo \F3::get("lang.Password") ?>" required>
		<button class="btn btn-lg btn-primary btn-lock" type="submit"><?php echo \F3::get('lang.SignInButton') ?></button>
	</form>
</div>

<?php echo \View::instance()->render('footer.php') ?>
