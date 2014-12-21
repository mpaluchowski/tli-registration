<?php
$renderer = \helpers\FormRendererFactory::className();
?>

<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.CodesHeader') ?></h1>
	</div>

<?php echo \View::instance()->render('message-alerts.php') ?>

	<div class="panel panel-default"><div class="panel-body">
	<form action="<?php echo \F3::get('ALIASES.admin_code_create') ?>" method="POST">
		<div class="form-group<?php if (isset($messages['email'])): ?> has-error<?php endif ?>">
			<label for="email" class="control-label"><?php echo \F3::get('lang.CodesRecipientEmail') ?></label>
			<input type="email" id="email" name="email" value="<?php if (isset($code)) echo $code->getEmail() ?>" placeholder="<?php echo \F3::get('lang.EmailPlaceholder') ?>" autocomplete="email" autofocus required class="form-control">
			<?php if (isset($messages['email'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $messages['email'] ?></p><?php endif; ?>
		</div>

		<div class="<?php if (isset($messages['pricing-items'])): ?> has-error<?php endif ?>">
			<label class="control-label"><?php echo \F3::get('lang.CodesSelectDiscountedItems') ?></label>
			<?php if (isset($messages['pricing-items'])): ?><p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $messages['pricing-items'] ?></p><?php endif; ?>
		</div>

		<div class="table-responsive">
			<table id="discount-code-items" class="table tli-table-form">
				<colgroup span="2"></colgroup>
				<colgroup span="<?php echo count(current($pricingItems)->prices) ?>" class="input-column-number"></colgroup>
				<thead>
					<tr>
						<th><?php echo \F3::get('lang.PaymentItemHead') ?></th>
						<th><?php echo \F3::get('lang.PaymentTypeHead') ?></th>
					<?php foreach (current($pricingItems)->prices as $currency => $price): ?>
						<th><?php echo \F3::get('lang.PaymentPriceHead') . ' ' . $currency ?></th>
					<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($pricingItems as $name => $item): ?>
					<tr id="pricing-item-<?php echo $item->id?>">
						<td>
							<div class="checkbox<?php if (isset($messages[$name])): ?> has-error<?php endif ?>">
								<label for="pricing-item-check-<?php echo $item->id?>">
									<input type="checkbox" name="pricing-items[<?php echo $name ?>]" value="<?php echo $item->id?>" id="pricing-item-check-<?php echo $item->id?>"<?php if (isset($code) && $code->hasPricingItem($name)): ?> checked<?php endif; ?>>
									<?php echo $renderer::pricing($item->name) ?>
								</label>
								<?php if (isset($messages[$name])): ?><p class="help-block">
									<span class="glyphicon glyphicon-info-sign"></span>
									<?php echo implode('<br><span class="glyphicon glyphicon-info-sign"></span> ', $messages[$name]) ?></p><?php endif; ?>
							</div>
						</td>
						<td><?php echo $renderer::pricing($item->name, $item->variant) ?></td>
					<?php foreach ($item->prices as $currency => $price): ?>
						<td>
							<div class="form-group<?php if (isset($messages[$name][$currency])): ?> has-error<?php endif ?>">
							<div class="input-group">
								<input type="number" name="price[<?php echo $item->id ?>][<?php echo $currency ?>]" value="<?php echo isset($code) && $code->hasPricingItem($name) ? $code->getPricingItem($name, $currency) : $price ?>" data-value-original="<?php echo $price ?>" min="0" max="<?php echo $price ?>" class="form-control" autocomplete="off" disabled>
								<span class="input-group-addon"><?php echo $price ?></span>
							</div>
							</div>
						</td>
					<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="checkbox form-group">
			<label>
				<input type="checkbox" name="send-email" id="send-email" style="margin-top: 7px;"<?php if (isset($sendEmail) && 'on' == $sendEmail): ?> checked<?php endif; ?>><?php echo \F3::get('lang.CodesSendByEmail') ?>
				<?php echo \F3::get('lang.InLanguage') ?>
				<select name="send-email-language" id="send-email-language" class="form-control input-sm" style="display: inline-block; width: auto; padding: 0 .4em; margin-left: .4em;"<?php if (!isset($sendEmail) || 'on' != $sendEmail): ?> disabled<?php endif; ?>>
				<?php foreach (\models\L11nManager::languagesSupported() as $language): ?>
					<option value="<?php echo $language ?>"<?php if ((isset($sendEmailLanguage) && $sendEmailLanguage == $language) || \models\L11nManager::language() == $language) : ?> selected<?php endif; ?>><?php echo \F3::get('lang.InLanguage-' . $language) ?></option>
				<?php endforeach; ?>
				</select>
			</label>
			<p class="help-block"><?php echo \F3::get('lang.CodesSendByEmailHelp') ?></p>
		</div>

		<button type="submit" class="btn btn-success" id="create-code-btn" data-email-label="<?php echo \F3::get('lang.CodesCreateEmailCodeButton') ?>" data-create-label="<?php echo \F3::get('lang.CodesCreateCodeButton') ?>"><?php echo isset($sendEmail) && 'on' == $sendEmail ? \F3::get('lang.CodesCreateEmailCodeButton') : \F3::get('lang.CodesCreateCodeButton') ?></button>
	</form>
	</div></div>

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th><?php echo \F3::get('lang.CodesRecipientEmail') ?></th>
					<th><?php echo \F3::get('lang.CodesCode') ?></th>
					<th><?php echo \F3::get('lang.CodesDateCreated') ?></th>
					<th><?php echo \F3::get('lang.CodesDateRedeemed') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($discountCodes as $code): ?>
				<tr data-id="<?php echo $code->getId() ?>">
					<td><?php echo $code->getEmail() ?></td>
					<td><?php echo $code->getCode() ?></td>
					<td><?php echo \helpers\View::formatDateTime($code->getDateCreated()) ?></td>
					<td><?php echo $code->getDateRedeemed() ? \helpers\View::formatDateTime($code->getDateRedeemed()) : "&mdash;" ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<script src="/js/discount-codes.js"></script>
<script>
  (function() {
    tliRegister.discountCodes.init();
  })();
</script>


<?php echo \View::instance()->render('footer.php') ?>
