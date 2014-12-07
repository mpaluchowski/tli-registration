<?php echo \View::instance()->render('header.php') ?>

<?php echo \View::instance()->render('administration/_navigation.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.CodesHeader') ?></h1>
	</div>

	<form action="" method="POST">
		<div class="form-group">
			<label for="email" class="control-label"><?php echo \F3::get('lang.CodesRecipientEmail') ?></label>
			<input type="email" name="email" placeholder="<?php echo \F3::get('lang.EmailPlaceholder') ?>" autocomplete="email" required class="form-control">
		</div>

		<label><?php echo \F3::get('lang.CodesSelectDiscountedItems') ?></label>

		<div class="table-responsive">
			<table class="table">
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
						<td><input type="text" value="<?php echo $price ?>" disabled></td>
					<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<button type="submit" class="btn btn-success"><?php echo \F3::get('lang.CodesCreateCodeButton') ?></button>
	</form>
</div>

<?php echo \View::instance()->render('footer.php') ?>
