<?php

namespace models;

/**
 * Manages Transaction data.
 */
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

	/**
	 * Store a new Transaction in the database.
	 *
	 * @param transaction \models\Transaction instance with transaction data to
	 * store.
	 * @return same transaction instance, with dateStarted added.
	 */
	function saveTransaction(\models\Transaction &$transaction) {
		$query = 'INSERT INTO ' . \F3::get('db_table_prefix') . 'transactions (
					session_id,
					fk_registration,
					amount,
					currency,
					date_started,
					date_valid
					)
				VALUES (
					:sessionId,
					:registrationId,
					:amount,
					:currency,
					:dateStarted,
					:dateValid
					)';
		\F3::get('db')->exec($query, [
				'sessionId' => $transaction->getSessionId(),
				'registrationId' => $transaction->getRegistrationId(),
				'amount' => $transaction->getAmount(),
				'currency' => $transaction->getCurrency(),
				'dateStarted' => $transaction->getDateStarted(),
				'dateValid' => $transaction->getDateValid(),
			]);

		return $transaction;
	}

	/**
	 * Update transaction with data received from payment processing party.
	 *
	 * @param sessionId the sessionId of the transaction to update
	 * @param orderId the Order ID received from the processor
	 * @param method the payment method code received from the processor
	 * @param statement the statement information received from the processor
	 */
	function updateTransactionPostPayment($sessionId, $orderId, $method, $statement) {
		$query = 'UPDATE ' . \F3::get('db_table_prefix') . 'transactions
				  SET order_id = :orderId,
					  method = :method,
					  statement = :statement,
					  date_paid = NOW()
				  WHERE session_id = :sessionId';
		\F3::get('db')->exec([
			'SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE',
			$query,
			],[[ // empty array, no params
			],[
				'orderId' => $orderId,
				'method' => $method,
				'statement' => $statement,
				'sessionId' => $sessionId,
			]]);
	}

	/**
	 * Load a Transaction based on its sessionId.
	 *
	 * @param sessionId the sessionId of the transaction
	 * @return instance of \models\Transaction or null of sessionId not found
	 */
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
				  WHERE t.session_id = :sessionId
				  LOCK IN SHARE MODE';
		$result = \F3::get('db')->exec($query, [
				'sessionId' => $sessionId,
			]);

		return $result
			? $this->parseQueryToTransaction($result[0])
			: null;
	}

	/**
	 * Load a Transaction based on its Registration ID.
	 *
	 * @param registrationId ID of the Registration to find the Transaction for
	 * @return instance of \models\Transaction or null if registrationId not
	 * found
	 */
	function readTransactionByRegistrationId($registrationId, $valid = true) {
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
				  WHERE t.fk_registration = :registrationId
				  ' . ($valid ? 'AND t.date_valid > NOW()' : '') . '
				  LOCK IN SHARE MODE';
		$result = \F3::get('db')->exec($query, [
				'registrationId' => $registrationId,
			]);

		return $result
			? $this->parseQueryToTransaction($result[0])
			: null;
	}

	/**
	 * Parse Transaction query result into an instance of \models\Transaction.
	 *
	 * @param result the result row returne from PDO
	 * @return instance of \models\Transaction
	 */
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
