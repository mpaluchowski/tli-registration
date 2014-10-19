<?php echo \View::instance()->render('header.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.RegistrationsListHeader') ?></h1>
	</div>

	<p><?php echo \F3::get('lang.RegistrationsListIntro', count($registrations)) ?></p>
</div>

<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<th style="white-space: nowrap;"><?php echo \F3::get('lang.Email') ?></th>
			<th style="white-space: nowrap;"><?php echo \F3::get('lang.DateEntered') ?></th>
			<th style="white-space: nowrap;"><?php echo \F3::get('lang.DatePaid') ?></th>
	<?php foreach ($fieldColumns as $column): ?>
			<th style="white-space: nowrap;"><?php echo $column ?></th>
	<?php endforeach; ?>
		</thead>
		<tbody>
	<?php foreach ($registrations as $registration): ?>
			<tr>
				<td><?php echo $registration->getEmail() ?></td>
				<td><?php echo strftime("%c", strtotime($registration->getDateEntered())) ?></td>
				<td><?php echo $registration->getDatePaid() ? strftime("%c", strtotime($registration->getDatePaid())) : "&mdash;" ?></td>
	<?php foreach ($fieldColumns as $column): ?>
				<td><?php echo $registration->hasField($column)
					? (
						is_array($registration->getField($column))
						? implode(', ', $registration->getField($column))
						: $registration->getField($column)
						)
					: "&mdash;" ?></td>
	<?php endforeach; ?>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php echo \View::instance()->render('footer.php') ?>
