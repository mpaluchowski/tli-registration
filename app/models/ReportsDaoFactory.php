<?php

namespace models;

abstract class ReportsDaoFactory {

	static function newInstance() {
		if (!\F3::get('reports_dao'))
			throw new \Exception('reports_dao configuration cannot be empty. Enter the full classpath of the \models\ReportsDao implementation.');

		$reportsDaoName = \F3::get('reports_dao');
		return new $reportsDaoName;
	}

}
