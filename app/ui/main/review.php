<?php echo \View::instance()->render('header.php') ?>

<div class="container">
	<h1><?php echo \F3::get('lang.RegistrationReviewHeader', $form->getField('full-name')) ?></h1>
</div>

<?php echo \View::instance()->render('footer.php') ?>
