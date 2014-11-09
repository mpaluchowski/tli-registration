<?php
if (\models\MessageManager::hasMessages()):
	foreach (\models\MessageManager::flushMessages() as $message):
?>
<div class="alert alert-<?php echo $message['type'] ?>" role="alert"><?php echo $message['content'] ?></div>
<?php
	endforeach;
endif;
?>
