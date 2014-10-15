<?php echo \View::instance()->render('header.php') ?>

<div class="container">
	<h1><?php echo \F3::get('lang.RegistrationReviewHeader', $form->getField('full-name')) ?></h1>

	<p><?php echo \F3::get('lang.RegistrationReviewIntro') ?></p>

	<a href="#" class="btn btn-lg btn-success"><?php echo \F3::get('lang.SelectPaymentOptionButton') ?></a>
</div>

<?php echo \View::instance()->render('footer.php') ?>
