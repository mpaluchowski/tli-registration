<?php

namespace controllers;

class Error {

	function handle($f3) {
		if ('404' == $f3->get('ERROR.code')) {
			echo \View::instance()->render('error/404.php');
		} else {
			echo \View::instance()->render('error/default.php');
		}
	}

}
