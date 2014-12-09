<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.CodesHeader') ?></h1>
	</div>

<?php echo \View::instance()->render('message-alerts.php') ?>

	<form action="<?php echo \F3::get('ALIASES.admin_code_create') ?>" method="POST">
		<div class="form-group">
			<label for="email" class="control-label"><?php echo \F3::get('lang.CodesRecipientEmail') ?></label>
			<input type="email" id="email" name="email" placeholder="<?php echo \F3::get('lang.EmailPlaceholder') ?>" autocomplete="email" autofocus required class="form-control">
		</div>

		<label><?php echo \F3::get('lang.CodesSelectDiscountedItems') ?></label>

		<div class="table-responsive">
			<table class="table tli-table-form">
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
				<?php foreach ($pricingItems as $item): ?>
					<tr id="pricing-item-<?php echo $item->id?>">
						<td>
							<div class="checkbox">
								<label for="pricing-item-check-<?php echo $item->id?>">
									<input type="checkbox" name="pricing-items[]" value="<?php echo $item->id?>" id="pricing-item-check-<?php echo $item->id?>">
									<?php echo $item->name ?>
								</label>
							</div>
						</td>
						<td><?php echo $item->variant ?></td>
					<?php foreach ($item->prices as $currency => $price): ?>
						<td><input type="number" name="price[<?php echo $item->id ?>][<?php echo $currency ?>]" value="<?php echo $price ?>" min="0" max="<?php echo $price ?>"></td>
					<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="checkbox form-group">
			<label>
				<input type="checkbox" name="send-email"><?php echo \F3::get('lang.CodesSendByEmail') ?>
				<p class="help-block"><?php echo \F3::get('lang.CodesSendByEmailHelp') ?></p>
			</label>
		</div>

		<button type="submit" class="btn btn-success"><?php echo \F3::get('lang.CodesCreateCodeButton') ?></button>
	</form>

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

<?php echo \View::instance()->render('footer.php') ?>
