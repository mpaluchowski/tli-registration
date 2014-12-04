<?php

namespace models;

class EventDao {

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

	function saveEvent(
		$name,
		$administratorId = null,
		array $data = null,
		$objectName = null,
		$objectId = null
		) {
		$query = 'INSERT INTO ' . \F3::get('db_table_prefix') . 'events (
				object_name,
				object_id,
				fk_administrator,
				ip,
				name,
				data,
				date_occurred
			)
			VALUES (
				:objectName,
				:objectId,
				:administratorId,
				:ip,
				:name,
				:data,
				NOW()
			)';
		\F3::get('db')->exec($query, [
				'objectName' => $objectName,
				'objectId' => $objectId,
				'administratorId' => $administratorId,
				'ip' => \F3::get('SERVER.REMOTE_ADDR'),
				'name' => $name,
				'data' => $data ? json_encode($data, JSON_UNESCAPED_UNICODE) : null,
			]);

		return \F3::get('db')->lastInsertID();
	}

}
