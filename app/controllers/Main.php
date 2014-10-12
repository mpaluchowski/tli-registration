<?php

namespace controllers;

class Main {

	function index($f3) {

		echo \View::instance()->render('main/index.php');
	}
}
