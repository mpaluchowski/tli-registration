<?php

namespace models;

/**
 * Collects, stores and provides messages to show to the user, persisting them
 * between requests.
 */
class MessageManager {

	/** Available message types, compatible with Bootstrap's alert component */
	private static $messageTypes = [
		'success',
		'warning',
		'danger',
		];

	/**
	 * Add a new message to the store.
	 *
	 * @param type Type of message. See {@see $messageTypes}
	 * @param content Text of the message.
	 */
	static function addMessage($type, $content) {
		self::addMessages([['type' => $type, 'content' => $content]]);
	}

	/**
	 * Add multiple messages to the store. Accepts an array of arrays, each
	 * must be structured as:
	 *
	 * <pre><code>
	 * [
	 *   [
	 *      'type' = '<message type>',
	 *      'content' = '<message text',
	 *   ]
	 * ]
	 * </code></pre>
	 *
	 * @param messages array with messages
	 */
	static function addMessages(array $messages) {
		self::initStore();

		foreach ($messages as $message) {
			if (!in_array($message['type'], self::$messageTypes)) {
				throw new Exception('Unsupported message type: ' . $message['type']);
			}
			\F3::push('SESSION.messages', $message);
		}
	}

	/**
	 * Checks if there are any messages pending for display.
	 *
	 * @return True when messages are awaiting in store.
	 */
	static function hasMessages() {
		return !\F3::devoid('SESSION.messages');
	}

	/**
	 * Retrieve and remove all messages from store. Usually used to display all
	 * currently pending messages.
	 *
	 * @return array with messages to display or empty array if none pending.
	 */
	static function flushMessages() {
		$messages = \F3::get('SESSION.messages');
		\F3::clear('SESSION.messages');
		return (bool)$messages
			? $messages
			: [];
	}

	/**
	 * Initialize the message store in F3. Checks if there is one already and if
	 * it's an array. If not, sets it up to an empty array.
	 */
	private static function initStore() {
		if (null == \F3::get('SESSION.messages')
				||!is_array(\F3::get('SESSION.messages'))) {
			\F3::set('SESSION.messages', []);
		}
	}

}
