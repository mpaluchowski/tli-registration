<?php \F3::set('bodyClass', "tli-navigated") ?>

<?php echo \View::instance()->render('header.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.SendEmailProblemHeader', $email) ?></h1>
	</div>

	<p><?php echo \F3::get('lang.SendEmailProblemInfo', $email) ?></p>
	<p>
		<a href="<?php echo \F3::get('ALIASES.registration_email') ?>" class="btn btn-primary active" role="button"><?php echo \F3::get('lang.HowProceedToPaymentHavingTroubleResendEmail') ?></a>
	</p>
</div>

<?php echo \View::instance()->render('_navigation.php') ?>

<?php echo \View::instance()->render('footer.php') ?>
