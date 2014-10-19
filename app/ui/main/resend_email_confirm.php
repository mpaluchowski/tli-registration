<?php echo \View::instance()->render('header.php') ?>

<div class="container">
	<div class="page-header">
		<h1>Registration e-mail sent to <?php echo $email ?></h1>
	</div>

	<p>We successfully sent an e-mail to your address at <strong><?php echo $email ?></strong>. Please allow a few minutes for it to arrive.</p>
</div>

<?php echo \View::instance()->render('footer.php') ?>
