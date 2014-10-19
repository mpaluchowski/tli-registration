<?php echo \View::instance()->render('header.php') ?>

<div class="container">
	<div class="page-header">
		<h1><?php echo \F3::get('lang.HowProceedToPaymentHeader') ?></h1>
	</div>

	<p><?php echo \F3::get('lang.HowProceedToPaymentInfo', $email) ?></p>

	<ol>
		<li><?php echo \F3::get('lang.HowProceedToPaymentStep1') ?></li>
		<li><?php echo \F3::get('lang.HowProceedToPaymentStep2') ?></li>
	</ol>

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo \F3::get('lang.HowProceedToPaymentHavingTroubleHeader') ?></h3>
		</div>
		<div class="panel-body">
			<p><?php echo \F3::get('lang.HowProceedToPaymentHavingTroubleInfo1') ?></p>

			<p>
				<a href="/registration/resend_email/<?php echo $email ?>" class="btn btn-primary active" role="button"><?php echo \F3::get('lang.HowProceedToPaymentHavingTroubleResendEmail') ?></a>
			</p>

			<p><?php echo \F3::get('lang.HowProceedToPaymentHavingTroubleInfo2') ?></p>
		</div>
	</div>
</div>

<?php echo \View::instance()->render('footer.php') ?>
