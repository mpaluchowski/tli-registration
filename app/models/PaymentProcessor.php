<?php

namespace models;

/**
 * Common interface for all payment processing services.
 */
interface PaymentProcessor {

	function registerTransaction(\models\Transaction $transaction, $returnUrl, $statusUrl);

	function getPaymentPageUrl($token);

	function testConnection();

	function isTestMode();

	function hasTestMode();

}
