<?php

namespace controllers;

class Error {

	function handle($f3) {
		if ($f3->get('logfile_error')) {
			$logger = new \Log($f3->get('logfile_error'));
			$logger->write(
				'ERROR: ' . $f3->get('ERROR.code') . PHP_EOL
				. "\t". $f3->get('ERROR.status') . PHP_EOL
				. "\t". $f3->get('ERROR.text') . PHP_EOL
				. "\t". print_r($f3->get('ERROR.trace'), true)
				);
		}

		// Clean output buffers if error happened mid-page
		while (ob_get_level())
			ob_end_clean();

		if ('404' == $f3->get('ERROR.code')) {
			echo \View::instance()->render('error/404.php');
		} else {
			echo \View::instance()->render('error/default.php');
		}
	}

}
