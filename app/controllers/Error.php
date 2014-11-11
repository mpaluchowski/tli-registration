<?php

namespace controllers;

class Error {

	function handle($f3) {
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
