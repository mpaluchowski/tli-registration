<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1>Statistics</h1>
	</div>

	<h3>Seats</h3>

	<div class="progress">
		<div class="progress-bar progress-bar-default" style="width: <?php echo $stats->registered / $totalSeats * 100 ?>%">
			<?php echo $stats->registered ?> Registered
		</div>
		<div class="progress-bar progress-bar-warning" style="width: <?php echo 100 - $stats->registered / $totalSeats * 100 ?>%">
			<?php echo $totalSeats - $stats->registered ?> Left
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4">
			<h3>Registrations by status</h3>
			<div id="pie-registrations-by-status" style="width: 100%; height: 100%;"></div>
		</div>
		<div class="col-sm-8">
			<h3>Registrations by week</h3>
			<div id="column-registrations-by-week" style="width: 100%; height: 100%;"></div>
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
			['Status', 'Registrations'],
			['Registered', <?php echo $stats->registered ?>],
			['Waiting List', <?php echo $stats->waitingList ?>],
			['Paid', <?php echo $stats->paid ?>],
			]);
		var options = {
			pieHole : 0.4
		};
		var chart = new google.visualization.PieChart(document.getElementById('pie-registrations-by-status'));
		chart.draw(data, options);
	}

	function drawRegistrationsByWeekChart() {
		var data = google.visualization.arrayToDataTable([
			['Week', 'Entered', 'Paid'],
		<?php foreach ($registrationsByWeek as $week): ?>
			['<?php echo $week->year . "/" . $week->week?>', <?php echo $week->entered ?>, <?php echo $week->paid ?>],
		<?php endforeach; ?>
			]);
		var chart = new google.visualization.ColumnChart(document.getElementById('column-registrations-by-week'));
		chart.draw(data);
	}
</script>

<?php echo \View::instance()->render('footer.php') ?>
