<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.StatisticsHeader') ?></h1>
	</div>

<?php if (\models\RegistrationDao::isSeatingLimited()): ?>
	<h3><?php echo \F3::get('lang.StatisticsSeatsHeader') ?></h3>

	<div class="progress">
		<div class="progress-bar progress-bar-success" style="width: <?php echo $stats['registrations-by-status']->paid / ($stats['registrations-by-status']->count + $stats['registrations-by-status']->left) * 100 ?>%">
			<?php echo \F3::get('lang.StatisticsSeatsPaid', $stats['registrations-by-status']->paid) ?>
		</div>
		<div class="progress-bar tli-progress-bar-none" style="width: <?php echo $stats['registrations-by-status']->left / ($stats['registrations-by-status']->count + $stats['registrations-by-status']->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsLeft', $stats['registrations-by-status']->left) ?>
		</div>
		<div class="progress-bar progress-bar-warning" style="width: <?php echo $stats['registrations-by-status']->pendingPayment / ($stats['registrations-by-status']->count + $stats['registrations-by-status']->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsPendingPayment', $stats['registrations-by-status']->pendingPayment) ?>
		</div>
		<div class="progress-bar" style="background: #000; width: <?php echo $stats['registrations-by-status']->pendingReview / ($stats['registrations-by-status']->count + $stats['registrations-by-status']->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsPendingReview', $stats['registrations-by-status']->pendingReview) ?>
		</div>
		<div class="progress-bar" style="background: #777; width: <?php echo $stats['registrations-by-status']->waitingList / ($stats['registrations-by-status']->count + $stats['registrations-by-status']->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsWaitingList', $stats['registrations-by-status']->waitingList) ?>
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

	<div class="row">
		<div class="col-sm-4">
			<h3><?php echo \F3::get('lang.StatisticsRegistrationsByClubHeader') ?></h3>
			<div id="bar-registrations-by-club" style="width: 100%;"></div>
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
		drawRegistrationsByClubChart();
	}

	function drawRegistrationsByStatusChart() {
		var data = google.visualization.arrayToDataTable([
			['<?php echo \F3::get('lang.StatisticsRegistrationStatusLabel') ?>', '<?php echo \F3::get('lang.StatisticsRegistrationsLabel') ?>'],
			['<?php echo \F3::get('lang.RegistrationStatus-PENDING_PAYMENT') ?>', <?php echo $stats['registrations-by-status']->pendingPayment ?>],
			['<?php echo \F3::get('lang.RegistrationStatus-PENDING_REVIEW') ?>', <?php echo $stats['registrations-by-status']->pendingReview ?>],
			['<?php echo \F3::get('lang.RegistrationStatus-WAITING_LIST') ?>', <?php echo $stats['registrations-by-status']->waitingList ?>],
			['<?php echo \F3::get('lang.RegistrationStatus-PAID') ?>', <?php echo $stats['registrations-by-status']->paid ?>],
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
		<?php foreach ($stats['registrations-by-week'] as $week): ?>
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

	function drawRegistrationsByClubChart() {
		var data = google.visualization.arrayToDataTable([
			['Club', 'Registrations'],
		<?php foreach ($stats['registrations-by-club'] as $club): ?>
			['<?php echo $club->name ?>', <?php echo $club->count ?>],
		<?php endforeach; ?>
			]);
		var options = {
			height: data.getNumberOfRows() * 40,
			colors : [
				'#5cb85c'
			],
			chartArea: { left: 150 },
			legend: { position: "none" },
		};

		var view = new google.visualization.DataView(data);
		view.setColumns([0, 1, {
				calc: "stringify",
				sourceColumn: 1,
				type: "string",
				role: "annotation"
			}]);

		var chart = new google.visualization.BarChart(document.getElementById('bar-registrations-by-club'));
		chart.draw(view, options);
	}
</script>

<?php echo \View::instance()->render('footer.php') ?>
