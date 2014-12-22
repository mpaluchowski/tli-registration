<?php

namespace models;

/**
 * Produces instances and information about the customized ReportsDao
 * implementation.
 */
abstract class ReportsDaoFactory {

	/**
	 * Produces a new instance of a ReportsDao implementation.
	 *
	 * @return new instance of a ReportsDao implementation.
	 * @throws Exception when an implementation was not configured.
	 */
	static function newInstance() {
		if (!\F3::get('reports_dao'))
			throw new \Exception('reports_dao configuration cannot be empty. Enter the full classpath of the \models\ReportsDao implementation.');

		$reportsDaoName = \F3::get('reports_dao');
		return new $reportsDaoName;
	}

}
