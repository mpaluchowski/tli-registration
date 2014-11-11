<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1>Statistics</h1>
	</div>

	<div class="progress">
		<div class="progress-bar progress-bar-default" style="width: <?php echo $stats->registered / $totalSeats * 100 ?>%">
			<?php echo $stats->registered ?> Registered
		</div>
		<div class="progress-bar progress-bar-warning" style="width: <?php echo 100 - $stats->registered / $totalSeats * 100 ?>%">
			<?php echo $totalSeats - $stats->registered ?> Left
		</div>
	</div>
</div>

<?php echo \View::instance()->render('footer.php') ?>
