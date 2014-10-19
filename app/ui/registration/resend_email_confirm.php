<?php echo \View::instance()->render('header.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.SendEmailSuccessHeader', $email) ?></h1>
	</div>

	<p><?php echo \F3::get('lang.SendEmailSuccessInfo', $email) ?></p>
</div>

<?php echo \View::instance()->render('footer.php') ?>
