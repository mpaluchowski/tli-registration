<?php

namespace models;

abstract class StatisticsDaoFactory {

	static function newInstance() {
		if (!\F3::get('statistics_dao'))
			throw new \Exception('statistics_dao configuration cannot be empty. Enter the full classpath of the \models\StatisticsDao implementation.');

		$statisticsDaoName = \F3::get('statistics_dao');
		return new $statisticsDaoName;
	}

}
