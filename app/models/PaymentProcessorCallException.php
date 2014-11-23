<?php

namespace models;

/**
 * Encapsulates errors on communication with payment processors.
 */
class PaymentProcessorCallException extends \Exception {

	protected $responseBody;

	/**
	 * @param $message Message for the exception
	 * @param $responseBody the HTTP call response body
	 * @param $code error code, 0 is default
	 * @param $previous previous exception instance that triggered this one
	 */
	function __construct($message, $responseBody, $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
		$this->responseBody = $responseBody;
	}

	function getResponseBody() {
		return $this->responseBody;
	}

}
