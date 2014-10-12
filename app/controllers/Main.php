<?php

namespace controllers;

class Main {

	function index($f3) {
		$dictionaryDao = new \models\DictionaryDao();

		$f3->set('clubs', $dictionaryDao->readAllClubs());

		echo \View::instance()->render('main/index.php');
	}

	function process_registration($f3) {
		$f3->reroute('/review/' . base64_encode($f3->serialize($f3->get('POST'))));
	}

	function registration_review($f3, $args) {
		print_r($f3->unserialize(base64_decode($args['data'])));
	}

}
