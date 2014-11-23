<?php

namespace models;

class TransactionDao {

	function __construct() {
		if (!\F3::exists('db')) {
			\F3::set('db', new \DB\SQL(
				'mysql:host=' . \F3::get('db_host') . ';port=' . \F3::get('db_port') . ';dbname=' . \F3::get('db_database'),
				\F3::get('db_username'),
				\F3::get('db_password'),
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
			));
		}
	}

	function saveTransaction(\models\Transaction &$transaction) {
		$dateStarted = time();

		$query = 'INSERT INTO ' . \F3::get('db_table_prefix') . 'transactions (
					session_id,
					fk_registration,
					amount,
					currency,
					date_started
					)
				VALUES (
					:sessionId,
					:registrationId,
					:amount,
					:currency,
					FROM_UNIXTIME(:dateStarted)
					)';
		\F3::get('db')->exec($query, [
				'sessionId' => $transaction->getSessionId(),
				'registrationId' => $transaction->getRegistrationId(),
				'amount' => $transaction->getAmount(),
				'currency' => $transaction->getCurrency(),
				'dateStarted' => $dateStarted,
			]);

		$transaction->setDateStarted(date('Y-m-d H:i:s', $dateStarted));

		return $transaction;
	}

	function updateTransactionPostPayment($sessionId, $orderId, $method, $statement) {
		$query = 'UPDATE ' . \F3::get('db_table_prefix') . 'transactions
				  SET order_id = :orderId,
					  method = :method,
					  statement = :statement,
					  date_paid = NOW()
				  WHERE session_id = :sessionId';
		\F3::get('db')->exec($query, [
				'orderId' => $orderId,
				'method' => $method,
				'statement' => $statement,
				'sessionId' => $sessionId,
			]);
	}

	function readTransactionBySessionId($sessionId) {
		$query = 'SELECT t.session_id,
						 t.fk_registration,
						 t.amount,
						 t.currency,
						 t.date_started,
						 t.date_paid,
						 r.email
				  FROM ' . \F3::get('db_table_prefix') . 'transactions t
				  JOIN ' . \F3::get('db_table_prefix') . 'registrations r
				    ON t.fk_registration = r.id_registration
				  WHERE t.session_id = :sessionId';
		$result = \F3::get('db')->exec($query, [
				'sessionId' => $sessionId,
			]);

		return $result
			? $this->parseQueryToTransaction($result[0])
			: null;
	}

	function readTransactionByRegistrationId($registrationId) {
		$query = 'SELECT t.session_id,
						 t.fk_registration,
						 t.amount,
						 t.currency,
						 t.date_started,
						 t.date_paid,
						 r.email
				  FROM ' . \F3::get('db_table_prefix') . 'transactions t
				  JOIN ' . \F3::get('db_table_prefix') . 'registrations r
				    ON t.fk_registration = r.id_registration
				  WHERE t.fk_registration = :registrationId';
		$result = \F3::get('db')->exec($query, [
				'registrationId' => $registrationId,
			]);

		return $result
			? $this->parseQueryToTransaction($result[0])
			: null;
	}

	function parseQueryToTransaction($result) {
		$transaction = new \models\Transaction(
			$result['session_id'],
			$result['fk_registration'],
			$result['amount'],
			$result['currency'],
			$this->getDefaultPaymentDescription(),
			$result['email'],
			$this->getDefaultPaymentCountry()
			);

		$transaction->setDateStarted($result['date_started']);
		$transaction->setDatePaid($result['date_paid']);

		return $transaction;
	}

	/**
	 * Generates a transaction session ID to identify the transaction with
	 * the selected payment processor.
	 *
	 * @return unique string representing the transaction session.
	 */
	static function generateSessionId() {
		return md5(session_id() . date("YmdHis"));
	}

	/**
	 * @return 3-letter code of the default currency to process payments in.
	 */
	static function getDefaultPaymentCurrency() {
		return \F3::get('payment_currency');
	}

	/**
	 * @return default payment description to send to othe processor.
	 */
	static function getDefaultPaymentDescription() {
		return \F3::get('payment_description');
	}

	/**
	 * @return country code for the default payment country.
	 */
	static function getDefaultPaymentCountry() {
		return \F3::get('payment_country');
	}

}
