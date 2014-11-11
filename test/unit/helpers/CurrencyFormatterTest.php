<?php
define('ROOT', '../../..');
$f3 = require(ROOT . '/lib-fatfree/base.php');

$test = new \Test;

include(ROOT . '/app/helpers/CurrencyFormatter.php');

/* moneyFormat() */

$test->expect(
	\helpers\CurrencyFormatter::moneyFormat('EUR', 123.456) == '€ 123.46',
	"EUR currency correctly formatted and rounded"
	);
$test->expect(
	\helpers\CurrencyFormatter::moneyFormat('PLN', 123.456) == '123.46zł',
	"PLN currency correctly formatted and rounded"
	);

$test->expect(
	\helpers\CurrencyFormatter::moneyFormat('EUR', 123.456, 3) == '€ 123.456',
	"EUR currency correctly formatted with 3 decimals"
	);

/* moneyFormatArray() */

$test->expect(
	\helpers\CurrencyFormatter::moneyFormatArray([
			'EUR' => 123.456,
			'PLN' => 34.233,
		]
		) == [
			'€ 123.46',
			'34.23zł',
		],
	"Array of currencies correctly formatted and rounded"
	);

$test->expect(
	\helpers\CurrencyFormatter::moneyFormatArray([
			'EUR' => 123.456,
			'PLN' => 34.233,
		], 3
		) == [
			'€ 123.456',
			'34.233zł',
		],
	"Array of currencies correctly formatted with 3 decimals"
	);

/* getSymbol() */

$test->expect(
	'€' === \helpers\CurrencyFormatter::getSymbol('EUR'),
	'€ returned for EUR as currency'
	);
$test->expect(
	'zł' === \helpers\CurrencyFormatter::getSymbol('PLN'),
	'"zł" returned for PLN currency'
	);
$test->expect(
	'$' === \helpers\CurrencyFormatter::getSymbol('USD'),
	'$ returned for USD currency'
	);

foreach ($test->results() as $result) {
	echo $result['text'] . PHP_EOL;
	if ($result['status'])
		echo ' Pass';
	else
		echo ' Fail (' . $result['source'] . ')';
	echo PHP_EOL;
}
