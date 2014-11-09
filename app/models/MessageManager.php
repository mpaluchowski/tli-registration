<?php

namespace models;

class MessageManager {

	private static $messageTypes = [
		'success',
		'warning',
		'danger',
		];

	static function addMessage($type, $content) {
		self::addMessages([['type' => $type, 'content' => $content]]);
	}

	static function addMessages(array $messages) {
		self::initStore();

		foreach ($messages as $message) {
			if (!in_array($message['type'], self::$messageTypes)) {
				throw new Exception('Unsupported message type: ' . $message['type']);
			}
			\F3::push('SESSION.messages', $message);
		}
	}

	static function hasMessages() {
		return !\F3::devoid('SESSION.messages');
	}

	static function flushMessages() {
		$messages = \F3::get('SESSION.messages');
		\F3::clear('SESSION.messages');
		return (bool)$messages
			? $messages
			: [];
	}

	private static function initStore() {
		if (null == \F3::get('SESSION.messages')
				||!is_array(\F3::get('SESSION.messages'))) {
			\F3::set('SESSION.messages', []);
		}
	}

}
