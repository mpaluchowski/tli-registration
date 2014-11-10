<?php echo \View::instance()->render('header.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.Error404Header') ?></h1>
	</div>

	<p><?php echo \F3::get('lang.Error404Info') ?></p>

	<a href="<?php echo \helpers\View::getBaseUrl() ?>" class="btn btn-lg btn-success"><?php echo \F3::get('lang.ErrorGoHome') ?></a>
</div>

<?php echo \View::instance()->render('footer.php') ?>
