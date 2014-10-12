<?php

namespace controllers;

class Main {

	function index($f3) {

		echo \View::instance()->render('main/index.php');
	}

	function process_registration($f3) {
		print_r($f3->get('POST'));
		print_r($f3->serialize($f3->get('POST')));
	}

	function registration_review($f3) {

	}

}
