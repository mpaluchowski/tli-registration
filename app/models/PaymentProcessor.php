<?php

namespace models;

/**
 * Common interface for all payment processing services.
 */
interface PaymentProcessor {

	function testConnection();

	function isTestMode();

	function hasTestMode();

}
