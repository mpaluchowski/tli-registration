<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.StatisticsHeader') ?></h1>
	</div>

<?php if (\models\RegistrationDao::isSeatingLimited()): ?>
	<h3><?php echo \F3::get('lang.StatisticsSeatsHeader') ?></h3>

	<div class="progress">
		<div class="progress-bar progress-bar-success" style="width: <?php echo $stats->registered / ($stats->count + $stats->left) * 100 ?>%">
			<?php echo \F3::get('lang.StatisticsSeatsRegistered', $stats->registered) ?>
		</div>
		<div class="progress-bar progress-bar-none" style="width: <?php echo $stats->left / ($stats->count + $stats->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsLeft', $totalSeats - $stats->registered) ?>
		</div>
		<div class="progress-bar" style="background: #000; width: <?php echo $stats->pendingReview / ($stats->count + $stats->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsPendingReview', $stats->pendingReview) ?>
		</div>
		<div class="progress-bar" style="background: #777; width: <?php echo $stats->waitingList / ($stats->count + $stats->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsWaitingList', $stats->waitingList) ?>
		</div>
	</div>
<?php endif; ?>

	<div class="row">
		<div class="col-sm-4">
			<h3><?php echo \F3::get('lang.StatisticsRegistrationsByStatusHeader') ?></h3>
			<div id="pie-registrations-by-status" style="width: 100%;"></div>
		</div>
		<div class="col-sm-8">
			<h3><?php echo \F3::get('lang.StatisticsRegistrationsByWeekHeader') ?></h3>
			<div id="column-registrations-by-week" style="width: 100%;"></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawCharts);

	function drawCharts() {
		drawRegistrationsByStatusChart();
		drawRegistrationsByWeekChart();
	}

	function drawRegistrationsByStatusChart() {
		var data = google.visualization.arrayToDataTable([
			['<?php echo \F3::get('lang.StatisticsRegistrationStatusLabel') ?>', '<?php echo \F3::get('lang.StatisticsRegistrationsLabel') ?>'],
			['<?php echo \F3::get('lang.RegistrationStatus-PENDING_PAYMENT') ?>', <?php echo $stats->pendingPayment ?>],
			['<?php echo \F3::get('lang.RegistrationStatus-PENDING_REVIEW') ?>', <?php echo $stats->pendingReview ?>],
			['<?php echo \F3::get('lang.RegistrationStatus-WAITING_LIST') ?>', <?php echo $stats->waitingList ?>],
			['<?php echo \F3::get('lang.RegistrationStatus-PAID') ?>', <?php echo $stats->paid ?>],
			]);
		var options = {
			pieHole : 0.4,
			colors : [
				'#f0ad4e', '#000', '#777', '#5cb85c'
			],
		};
		var chart = new google.visualization.PieChart(document.getElementById('pie-registrations-by-status'));
		chart.draw(data, options);
	}

	function drawRegistrationsByWeekChart() {
		var data = google.visualization.arrayToDataTable([
			['Week', '<?php echo \F3::get('lang.StatisticsRegistrationsRegisteredLabel') ?>', '<?php echo \F3::get('lang.StatisticsRegistrationsPaidLabel') ?>'],
		<?php foreach ($registrationsByWeek as $week): ?>
			['<?php echo $week->year . "/" . $week->week?>', <?php echo $week->entered ?>, <?php echo $week->paid ?>],
		<?php endforeach; ?>
			]);
		var options = {
			colors : [
				'#f0ad4e', '#5cb85c'
			]
		};
		var chart = new google.visualization.ColumnChart(document.getElementById('column-registrations-by-week'));
		chart.draw(data, options);
	}
</script>

<?php echo \View::instance()->render('footer.php') ?>
