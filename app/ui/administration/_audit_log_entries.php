<?php foreach ($events as $event): ?>
<tr data-id="<?php echo $event->id ?>">
	<td class="text-nowrap">
		<img src="<?php echo \helpers\View::getGravatarUrl($event->administratorEmail, 30) ?>" alt="<?php echo $event->administratorName ?>">
		<?php echo $event->administratorName ?>
	</td>
	<td><?php echo $event->name ?></td>
	<td><?php echo $event->objectName ? $event->objectName . '(' . $event->objectId . ')' : "&mdash;" ?></td>
	<td><?php echo $event->data ?: "&mdash;" ?></td>
	<td class="text-nowrap"><?php echo \helpers\View::formatDateTime($event->dateOccurred) ?></td>
</tr>
<?php endforeach; ?>
