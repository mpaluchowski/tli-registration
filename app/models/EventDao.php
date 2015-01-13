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

	/**
	 * Save a new event into the EventLog.
	 *
	 * @param name Name of the event.
	 * @param administratorId optional ID of the administrator, who triggered
	 * the event.
	 * @param data optional additional data on the event.
	 * @param objectName optional name of object the event was performed on.
	 * @param objectId optional ID of object the event was performed on.
	 * @return ID of the event stored in the database.
	 */
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

	/**
	 * Read all events from the database.
	 *
	 * @param $page page to return, 0-indexed
	 * @param $limit records to return per page
	 * @return Array of objects with event data.
	 */
	function readEvents($page = 0, $limit = null) {
		if (!$limit) $limit = \F3::get('paged_records_number');

		$offset = $page * $limit;

		$query = 'SELECT e.id_event,
						 e.object_name,
						 e.object_id,
						 e.ip,
						 e.name,
						 e.data,
						 e.date_occurred,
						 a.id_administrator,
						 a.full_name,
						 a.email
				  FROM ' . \F3::get('db_table_prefix') . 'events e
				  LEFT JOIN ' . \F3::get('db_table_prefix') . 'administrators a
				    ON e.fk_administrator = a.id_administrator
				  ORDER BY e.id_event DESC
				  LIMIT :offset, :limit';
		$result = \F3::get('db')->exec($query, [
				'offset' => $offset,
				'limit' => $limit,
			]);

		$events = [];
		foreach ($result as $row) {
			$events[] = (object)[
				'id' => $row['id_event'],
				'objectName' => $row['object_name'],
				'objectId' => $row['object_id'],
				'ip' => $row['ip'],
				'name' => $row['name'],
				'data' => $row['data'],
				'dateOccurred' => $row['date_occurred'],
				'administratorId' => $row['id_administrator'],
				'administratorName' => $row['full_name'],
				'administratorEmail' => $row['email'],
			];
		}

		return $events;
	}

}
