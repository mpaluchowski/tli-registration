<?php

namespace models;

/**
 * Produces instances and information about the customized StatisticsDao
 * implementation.
 */
abstract class StatisticsDaoFactory {

	/**
	 * Produces a new instance of a StatisticsDao implementation.
	 *
	 * @return new instance of a StatisticsDao implementation.
	 * @throws Exception when an implementation was not configured.
	 */
	static function newInstance() {
		if (!\F3::get('statistics_dao'))
			throw new \Exception('statistics_dao configuration cannot be empty. Enter the full classpath of the \models\StatisticsDao implementation.');

		$statisticsDaoName = \F3::get('statistics_dao');
		return new $statisticsDaoName;
	}

}
