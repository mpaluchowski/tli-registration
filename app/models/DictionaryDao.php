<?php

namespace models;

/**
 * Operations related to dictionary data.
 */
class DictionaryDao {

	function __construct() {
		\F3::set('db', new \DB\SQL(
			'mysql:host=' . \F3::get('db_host') . ';port=' . \F3::get('db_port') . ';dbname='.\F3::get('db_database'),
			\F3::get('db_username'),
			\F3::get('db_password'),
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
			));
	}

	/**
	 * Retrieves all clubs from the database dictionary, ordered by name.
	 *
	 * @return Array of objects representing clubs, with their ID and name.
	 */
	function readAllClubs() {
		$query = 'SELECT c.id_club,
						 c.name
				  FROM ' . \F3::get('db_table_prefix') . 'clubs c
				  ORDER BY c.name';
		$rows = \F3::get('db')->exec($query);

		$clubs = [];
		foreach ($rows as $row) {
			$clubs[] = (object) [
				'id' => $row['id_club'],
				'name' => $row['name'],
				];
		}

		return $clubs;
	}

}
