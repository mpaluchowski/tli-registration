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

	static function generateSessionId() {
		return md5(session_id() . date("YmdHis"));
	}

	static function getDefaultPaymentCurrency() {
		return \F3::get('payment_currency');
	}

	static function getDefaultPaymentDescription() {
		return \F3::get('payment_description');
	}

	static function getDefaultPaymentCountry() {
		return \F3::get('payment_country');
	}

}
