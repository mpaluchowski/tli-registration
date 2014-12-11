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
		return [
			'registrations-by-club' => $this->readRegistrationsByClub(),
			'officers-by-club' => $this->readOfficersByClub(),
			'officer-ratio' => $this->readOfficerRatio(),
		];
	}

	/**
	 * Return a list of clubs with the number of registrations from each one
	 * of them.
	 *
	 * @return array with objects, one per club, name and count of registrations.
	 */
	function readRegistrationsByClub() {
		$query = "SELECT rf.value,
						 COUNT(rf.fk_registration) AS registrations
				  FROM " . \F3::get('db_table_prefix') . "registration_fields rf
				  WHERE rf.name = 'home-club'
				  GROUP BY rf.value
				  ORDER BY registrations DESC,
				  		   rf.value";
		$result = \F3::get('db')->exec($query);

		$stats = [];
		foreach ($result as $row) {
			$stats[] = (object)[
				'name' => json_decode($row['value']),
				'count' => $row['registrations'],
			];
		}
		return $stats;
	}

	/**
	 * Return a list of clubs with the number of officers registered from each
	 * one, and positions that registered.
	 *
	 * @return array with objects, one per club, name, count and array of
	 * positions.
	 */
	function readOfficersByClub() {
		$query = "SELECT rf1.value AS club,
						 COUNT(rf2.fk_registration) AS officers,
						 SUM(r.date_paid IS NULL) AS officers_unpaid,
						 SUM(r.date_paid IS NOT NULL) AS officers_paid,
						 GROUP_CONCAT(rf2.value SEPARATOR \"|\") AS positions
				  FROM " . \F3::get('db_table_prefix') . "registration_fields rf1
				  LEFT JOIN " . \F3::get('db_table_prefix') . "registration_fields rf2
					ON rf1.fk_registration = rf2.fk_registration
					AND rf2.name = 'exec-position'
					AND rf2.value <> '\"none\"'
				  LEFT JOIN " . \F3::get('db_table_prefix') . "registrations r
					ON r.id_registration = rf2.fk_registration
				  WHERE rf1.name = 'home-club'
				    AND rf1.value <> '\"None\"'
				  GROUP BY rf1.value
				  ORDER BY rf1.value";
		$result = \F3::get('db')->exec($query);

		$stats = [];
		foreach ($result as $row) {
			$stats[] = (object)[
				'name' => json_decode($row['club']),
				'count' => $row['officers'],
				'countOfficersUnpaid' => $row['officers_unpaid'],
				'countOfficersPaid' => $row['officers_paid'],
				'positions' => array_map(function ($item) {
					return json_decode($item);
				}, explode("|", $row['positions'])),
			];
		}
		return $stats;
	}

	/**
	 * Reads the counts of officers and non-officers registered.
	 *
	 * @return object with two fields for officerCount and nonOfficerCount
	 */
	function readOfficerRatio() {
		$query = "SELECT SUM(rf.value = '\"none\"') AS non_officers,
						 SUM(rf.value <> '\"none\"') AS officers
				  FROM tli_registration_fields rf
				  WHERE rf.name = 'exec-position'";
		$result = \F3::get('db')->exec($query);

		return (object)[
			'officerCount' => $result[0]['officers'],
			'nonOfficerCount' => $result[0]['non_officers'],
			];
	}

}
