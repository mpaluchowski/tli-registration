<?php
$renderer = \helpers\FormRendererFactory::className();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo \F3::get('lang.EmailDiscountCodeSubject', $code->getEmail()) ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body style="margin: 0; padding: 0;">
	<p><?php echo \F3::get('lang.EmailDiscountCodeIntro') ?></p>

	<p style="font-size: 200%; font-weight: bold;"><?php echo $code->getCode() ?></p>

	<p><?php echo \F3::get('lang.EmailDiscountCodeInstructions') ?></p>

	<h2><?php echo \F3::get('lang.EmailDiscountCodeItemsHeader') ?></h2>

	<table border="0" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th style="padding: 4px;"><?php echo \F3::get('lang.PaymentItemHead') ?></th>
				<th style="padding: 4px;"><?php echo \F3::get('lang.PaymentTypeHead') ?></th>
			<?php foreach (current($pricingItems)->prices as $currency => $price): ?>
				<th style="padding: 4px;"><?php echo \F3::get('lang.PaymentPriceHead') . ' ' . $currency ?></th>
			<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($code->getPricingItems() as $name => $item): ?>
			<tr>
				<td style="padding: 4px;"><?php echo $renderer::pricing($pricingItems[$name]->name) ?></td>
				<td style="padding: 4px;"><?php echo $renderer::pricing($pricingItems[$name]->name, $pricingItems[$name]->variant) ?></td>
			<?php foreach ($item['prices'] as $currency => $price): ?>
				<td style="text-align: right; padding: 4px;">
					<del><?php echo \helpers\CurrencyFormatter::moneyFormat($currency, $pricingItems[$name]->prices[$currency]) ?></del><br>
					<?php echo  \helpers\CurrencyFormatter::moneyFormat($currency, $price) ?>
				</td>
			<?php endforeach; // Prices ?>
			</tr>
		<?php endforeach; //Pricing Items ?>
		</tbody>
	</table>
</body>
</html>
