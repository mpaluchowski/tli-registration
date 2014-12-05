<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.StatisticsHeader') ?></h1>
	</div>

<?php if (\models\RegistrationDao::isSeatingLimited()): ?>
	<h3><?php echo \F3::get('lang.StatisticsSeatsHeader') ?></h3>

	<div class="progress">
		<div class="progress-bar progress-bar-success" style="width: <?php echo $registrationsByStatus->paid / ($registrationsByStatus->count + $registrationsByStatus->left) * 100 ?>%">
			<?php echo \F3::get('lang.StatisticsSeatsPaid', $registrationsByStatus->paid) ?>
		</div>
		<div class="progress-bar tli-progress-bar-none" style="width: <?php echo $registrationsByStatus->left / ($registrationsByStatus->count + $registrationsByStatus->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsLeft', $registrationsByStatus->left) ?>
		</div>
		<div class="progress-bar progress-bar-warning" style="width: <?php echo $registrationsByStatus->pendingPayment / ($registrationsByStatus->count + $registrationsByStatus->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsPendingPayment', $registrationsByStatus->pendingPayment) ?>
		</div>
		<div class="progress-bar" style="background: #000; width: <?php echo $registrationsByStatus->pendingReview / ($registrationsByStatus->count + $registrationsByStatus->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsPendingReview', $registrationsByStatus->pendingReview) ?>
		</div>
		<div class="progress-bar" style="background: #777; width: <?php echo $registrationsByStatus->waitingList / ($registrationsByStatus->count + $registrationsByStatus->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsWaitingList', $registrationsByStatus->waitingList) ?>
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
			['<?php echo \F3::get('lang.RegistrationStatus-PENDING_PAYMENT') ?>', <?php echo $registrationsByStatus->pendingPayment ?>],
			['<?php echo \F3::get('lang.RegistrationStatus-PENDING_REVIEW') ?>', <?php echo $registrationsByStatus->pendingReview ?>],
			['<?php echo \F3::get('lang.RegistrationStatus-WAITING_LIST') ?>', <?php echo $registrationsByStatus->waitingList ?>],
			['<?php echo \F3::get('lang.RegistrationStatus-PAID') ?>', <?php echo $registrationsByStatus->paid ?>],
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

	function drawRegistrationsByClubChart() {
		var data = google.visualization.arrayToDataTable([
			['Club', 'Registrations'],
		<?php foreach ($stats['registrations-by-club'] as $club): ?>
			['<?php echo $club->name ?>', <?php echo $club->count ?>],
		<?php endforeach; ?>
			]);
		var options = {
			colors : [
				'#5cb85c'
			],
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
