<?php

namespace controllers;

class Error {

	function handle($f3) {
		if ('404' == $f3->get('ERROR.code')) {
			echo 404;
		} else {
			echo $f3->get('ERROR.code');
		}
	}

}
