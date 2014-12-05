<?php

namespace models;

class StatisticsDaoImpl implements \models\StatisticsDao {

	public function __construct() {
		if (!\F3::exists('db')) {
			\F3::set('db', new \DB\SQL(
				'mysql:host=' . \F3::get('db_host') . ';port=' . \F3::get('db_port') . ';dbname=' . \F3::get('db_database'),
				\F3::get('db_username'),
				\F3::get('db_password'),
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
			));
		}
	}

	/**
	 * @see \models\StatisticsDao#readStatistics()
	 */
	function readStatistics() {
		$query = "SELECT rf.value,
						 COUNT(rf.fk_registration) AS registrations
				  FROM " . \F3::get('db_table_prefix') . "registration_fields rf
				  WHERE rf.name = 'home-club'
				  GROUP BY rf.value
				  ORDER BY registrations DESC,
				  		   rf.value";
		$result = \F3::get('db')->exec($query);

		$stats = ['registrations-by-club' => []];
		foreach ($result as $row) {
			$stats['registrations-by-club'][] = (object)[
				'name' => json_decode($row['value']),
				'count' => $row['registrations'],
			];
		}
		return $stats;
	}

}
