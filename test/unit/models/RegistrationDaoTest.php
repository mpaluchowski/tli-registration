<?php
define('ROOT', '../../..');
$f3 = require(ROOT . '/lib-fatfree/base.php');

$test = new \Test;

include(ROOT . '/app/models/RegistrationDao.php');

/* validateHash() */

$test->expect(
	\models\RegistrationDao::validateHash("30085d747a6d6e2711c7c2446fdf296dc65d67f5"),
	"Digit-starting correct hash validated to true"
	);

$test->expect(
	\models\RegistrationDao::validateHash("d6970ca7593b49e6943976495557a12111042535"),
	"Alpha-starting correct hash validated to true"
	);

$test->expect(
	\models\RegistrationDao::validateHash("0000000000000000000000000000001111111111"),
	"Numeric 40 char code validated to true"
	);

$test->expect(
	!\models\RegistrationDao::validateHash("d6970ca7593b49e69439764955"),
	"Code too short validated to false"
	);

$test->expect(
	!\models\RegistrationDao::validateHash("d6970ca7593b49e69439764955d6970ca7593b49e69439764955"),
	"Code too long validated to false"
	);

$test->expect(
	!\models\RegistrationDao::validateHash("123456"),
	"Numeric short code validated to false"
	);

/* Results */

foreach ($test->results() as $result) {
	echo $result['text'] . PHP_EOL;
	if ($result['status'])
		echo "\033[32m Pass\033[0m";
	else
		echo "\033[31m Fail\033[0m (" . $result['source'] . ")";
	echo PHP_EOL;
}
