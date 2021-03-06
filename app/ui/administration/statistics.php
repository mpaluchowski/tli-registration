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
		<div class="progress-bar" style="background: <?php echo \helpers\View::getRegistrationStatusLabel('pending-review', true) ?>; width: <?php echo $stats['registrations-by-status']->pendingReview / ($stats['registrations-by-status']->count + $stats['registrations-by-status']->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsPendingReview', $stats['registrations-by-status']->pendingReview) ?>
		</div>
		<div class="progress-bar" style="background: <?php echo \helpers\View::getRegistrationStatusLabel('waiting-list', true) ?>; width: <?php echo $stats['registrations-by-status']->waitingList / ($stats['registrations-by-status']->count + $stats['registrations-by-status']->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsWaitingList', $stats['registrations-by-status']->waitingList) ?>
		</div>
		<div class="progress-bar" style="background: <?php echo \helpers\View::getRegistrationStatusLabel('cancelled', true) ?>; width: <?php echo $stats['registrations-by-status']->cancelled / ($stats['registrations-by-status']->count + $stats['registrations-by-status']->left) * 100 ?>%;">
			<?php echo \F3::get('lang.StatisticsSeatsCancelled', $stats['registrations-by-status']->cancelled) ?>
		</div>
	</div>
<?php endif; ?>

	<div class="row">
		<div class="col-sm-4">
			<h3><?php echo \F3::get('lang.StatisticsRegistrationsByStatusHeader') ?></h3>
			<div id="pie-registrations-by-status"><span class="chart-loader"><i class="fa fa-spinner fa-spin"></i></span></div>
		</div>
		<div class="col-sm-8">
			<h3><?php echo \F3::get('lang.StatisticsRegistrationsByWeekHeader') ?></h3>
			<div id="column-registrations-by-week"><span class="chart-loader"><i class="fa fa-spinner fa-spin"></i></span></div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4">
			<h3><?php echo \F3::get('lang.StatisticsRegistrationsByClubHeader') ?></h3>
			<p><small><?php echo \F3::get('lang.StatisticsIncludePaidPendingPaymentInfo') ?></small></p>
			<div id="bar-registrations-by-club"><span class="chart-loader"><i class="fa fa-spinner fa-spin"></i></span></div>
		</div>
		<div class="col-sm-4">
			<h3><?php echo \F3::get('lang.StatisticsOfficersByClubHeader') ?></h3>
			<p><small><?php echo \F3::get('lang.StatisticsIncludePaidPendingPaymentInfo') ?></small></p>
			<div id="bar-officers-by-club"><span class="chart-loader"><i class="fa fa-spinner fa-spin"></i></span></div>
		</div>
		<div class="col-sm-4">
			<h3><?php echo \F3::get('lang.StatisticsOfficerRatioHeader') ?></h3>
			<p><small><?php echo \F3::get('lang.StatisticsIncludePaidPendingPaymentInfo') ?></small></p>
			<div id="pie-officer-ratio"><span class="chart-loader"><i class="fa fa-spinner fa-spin"></i></span></div>

			<h3><?php echo \F3::get('lang.StatisticsAccommodationHeader') ?></h3>
			<p><small><?php echo \F3::get('lang.StatisticsIncludePaidPendingPaymentInfo') ?></small></p>
			<div id="pie-accommodation-ratio"><span class="chart-loader"><i class="fa fa-spinner fa-spin"></i></span></div>

			<h3><?php echo \F3::get('lang.StatisticsEventEnrollmentHeader') ?></h3>
			<p><small><?php echo \F3::get('lang.StatisticsIncludePaidPendingPaymentInfo') ?></small></p>
			<div id="bar-event-enrollment"><span class="chart-loader"><i class="fa fa-spinner fa-spin"></i></span></div>
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
		drawOfficersByClubChart();
		drawOfficerRatioChart();
		drawAccommodationRatioChart();
		drawEventEnrollmentChart();
	}

	function drawRegistrationsByStatusChart() {
		var data = google.visualization.arrayToDataTable([
			[<?php echo json_encode(\F3::get('lang.StatisticsRegistrationStatusLabel')) ?>, '<?php echo \F3::get('lang.StatisticsRegistrationsLabel') ?>'],
			[<?php echo json_encode(\F3::get('lang.RegistrationStatus-pending-payment')) ?>, <?php echo $stats['registrations-by-status']->pendingPayment ?>],
			[<?php echo json_encode(\F3::get('lang.RegistrationStatus-paid')) ?>, <?php echo $stats['registrations-by-status']->paid ?>],
			[<?php echo json_encode(\F3::get('lang.RegistrationStatus-waiting-list')) ?>, <?php echo $stats['registrations-by-status']->waitingList ?>],
			[<?php echo json_encode(\F3::get('lang.RegistrationStatus-pending-review')) ?>, <?php echo $stats['registrations-by-status']->pendingReview ?>],
			[<?php echo json_encode(\F3::get('lang.RegistrationStatus-cancelled')) ?>, <?php echo $stats['registrations-by-status']->cancelled ?>],
			]);
		var options = {
			pieHole : 0.4,
			colors : [
				'<?php echo \helpers\View::getRegistrationStatusLabel('pending-payment', true) ?>',
				'<?php echo \helpers\View::getRegistrationStatusLabel('paid', true) ?>',
				'<?php echo \helpers\View::getRegistrationStatusLabel('waiting-list', true) ?>',
				'<?php echo \helpers\View::getRegistrationStatusLabel('pending-review', true) ?>',
				'<?php echo \helpers\View::getRegistrationStatusLabel('cancelled', true) ?>',
			],
			height: 150,
			chartArea: {
				height: "90%",
			}
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
				'<?php echo \helpers\View::getRegistrationStatusLabel('pending-payment', true) ?>',
				'<?php echo \helpers\View::getRegistrationStatusLabel('paid', true) ?>',
			],
			height: 150,
			chartArea: {
				height: "86%",
				left: "7%",
				top: 5
			}
		};

		var view = new google.visualization.DataView(data);
			view.setColumns([0, 1, {
				calc: "stringify",
				sourceColumn: 1,
				type: "string",
				role: "annotation" },
			2, {
				calc: "stringify",
				sourceColumn: 2,
				type: "string",
				role: "annotation"
			}]);

		var chart = new google.visualization.ColumnChart(document.getElementById('column-registrations-by-week'));
		chart.draw(view, options);
	}

	function drawRegistrationsByClubChart() {
		var data = google.visualization.arrayToDataTable([
			['<?php echo \F3::get('lang.StatisticsClubLabel') ?>', '<?php echo \F3::get('lang.StatisticsRegistrationsLabel') ?>'],
		<?php foreach ($stats['registrations-by-club'] as $club): ?>
			[<?php echo json_encode($club->name) ?>, <?php echo $club->count ?>],
		<?php endforeach; ?>
			]);
		var options = {
			height: data.getNumberOfRows() * 25,
			colors : [
				'<?php echo \helpers\View::getRegistrationStatusLabel('paid', true) ?>',
			],
			chartArea: {
				left: 150,
				height: '96%',
			},
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

	function drawOfficersByClubChart() {
		var data = google.visualization.arrayToDataTable([
			[
				'<?php echo \F3::get('lang.StatisticsClubLabel') ?>',
				'<?php echo \F3::get('lang.StatisticsOfficersPaidLabel') ?>',
				{ role: 'style' },
				'<?php echo \F3::get('lang.StatisticsOfficersUnpaidLabel') ?>',
				{ role: 'style' },
			],
		<?php foreach ($stats['officers-by-club'] as $club): ?>
			[
				<?php echo json_encode($club->name) ?>,
				<?php echo $club->countOfficersPaid ?>,
				'<?php echo $club->countOfficersPaid < 4 ? '#d9534f' : \helpers\View::getRegistrationStatusLabel('paid', true) ?>',
				<?php echo $club->countOfficersUnpaid ?>,
				'<?php echo \helpers\View::getRegistrationStatusLabel('pending-payment', true) ?>',
			],
		<?php endforeach; ?>
			]);
		var options = {
			height: data.getNumberOfRows() * 25,
			chartArea: {
				left: 150,
				height: '96%',
			},
			legend: { position: "none" },
			isStacked: true,
		};

		var chart = new google.visualization.BarChart(document.getElementById('bar-officers-by-club'));
		chart.draw(data, options);
	}

	function drawAccommodationRatioChart() {
		var data = google.visualization.arrayToDataTable([
			['Type', '<?php echo \F3::get('lang.StatisticsRegistrationsLabel') ?>'],
			['<?php echo \F3::get('lang.StatisticsAccommodation-stay') ?>', <?php echo $stats['accommodation-ratio']->stay ?>],
			['<?php echo \F3::get('lang.StatisticsAccommodation-host') ?>', <?php echo $stats['accommodation-ratio']->host ?>],
			['<?php echo \F3::get('lang.StatisticsAccommodation-independent') ?>', <?php echo $stats['accommodation-ratio']->independent ?>],
			]);
		var options = {
			pieHole : 0.4,
			pieSliceText : 'value',
			colors : [
				'<?php echo \helpers\View::toastmastersColor('crimson') ?>',
				'<?php echo \helpers\View::toastmastersColor('yellow') ?>',
				'<?php echo \helpers\View::toastmastersColor('grey') ?>',
			],
			height: 150,
			chartArea: {
				height: "90%",
			}
		};
		var chart = new google.visualization.PieChart(document.getElementById('pie-accommodation-ratio'));
		chart.draw(data, options);
	}

	function drawOfficerRatioChart() {
		var data = google.visualization.arrayToDataTable([
			['Type', '<?php echo \F3::get('lang.StatisticsRegistrationsLabel') ?>'],
			['<?php echo \F3::get('lang.StatisticsOfficersLabel') ?>', <?php echo $stats['officer-ratio']->officerCount ?>],
			['<?php echo \F3::get('lang.StatisticsNonOfficersLabel') ?>', <?php echo $stats['officer-ratio']->nonOfficerCount ?>],
			]);
		var options = {
			pieHole : 0.4,
			pieSliceText : 'value',
			colors : [
				'<?php echo \helpers\View::toastmastersColor('crimson') ?>',
				'<?php echo \helpers\View::toastmastersColor('grey') ?>',
			],
			height: 150,
			chartArea: {
				height: "90%",
			}
		};
		var chart = new google.visualization.PieChart(document.getElementById('pie-officer-ratio'));
		chart.draw(data, options);
	}

	function drawEventEnrollmentChart() {
		var data = google.visualization.arrayToDataTable([
			[
				'<?php echo \F3::get('lang.StatisticsEventLabel') ?>',
				'<?php echo \F3::get('lang.StatisticsOfficersPaidLabel') ?>',
				'<?php echo \F3::get('lang.StatisticsOfficersUnpaidLabel') ?>',
			],
		<?php foreach ($stats['event-enrollment'] as $name => $counts): ?>
			[
				<?php echo json_encode(\F3::get('lang.' . $name)) ?>,
				<?php echo $counts['paid'] ?>,
				<?php echo $counts['unpaid'] ?>,
			],
		<?php endforeach; ?>
			]);
		var options = {
			height: data.getNumberOfRows() * 25,
			colors : [
				'<?php echo \helpers\View::getRegistrationStatusLabel('paid', true) ?>',
				'<?php echo \helpers\View::getRegistrationStatusLabel('pending-payment', true) ?>',
			],
			chartArea: {
				left: 100,
				height: '96%',
			},
			legend: { position: "none" },
			isStacked: true,
		};

		var chart = new google.visualization.BarChart(document.getElementById('bar-event-enrollment'));
		chart.draw(data, options);
	}
</script>

<?php echo \View::instance()->render('footer.php') ?>
