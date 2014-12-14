<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
</body>
</html>
