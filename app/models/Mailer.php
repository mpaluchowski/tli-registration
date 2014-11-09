<?php

namespace models;

class Mailer {

	/**
	 * Send an email.
	 *
	 * @param to recipient's email
	 * @param subject subject of the email
	 * @param message plaintext message to send as email
	 * @return bool true when succeeded, false otherwise
	 */
	function sendEmail($to, $subject, $message) {
		$smtp = new \SMTP(
			\F3::get('smtp_host'),
			\F3::get('smtp_port'),
			\F3::get('smtp_scheme'),
			\F3::get('smtp_user'),
			\F3::get('smtp_pass')
			);

		$smtp->set('Content-Type', 'text/html; charset=UTF-8');
		$smtp->set('From', $this->wrapEmail(\F3::get('email_from')));
		$smtp->set('Reply-To', $this->wrapEmail(\F3::get('email_reply_to')));
		$smtp->set('To', $this->wrapEmail($this->getRealToEmail($to)));
		if ($this->inTestMode()) {
			$smtp->set('X-Original-To', $this->wrapEmail($to));
		}

		$smtp->set('Subject', $subject);

		return $smtp->send($message);
	}

	/**
	 * Wraps an email in brackets, if it's only the email and doesn't have
	 * them.
	 *
	 * @param email string
	 * @return string email with brackets, ie. <john@example.org>
	 */
	function wrapEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
			return "<" . $email . ">";
		else
			return $email;
	}

	/**
	 * Turns a name and e-mail address info a full e-mail string, ie.
	 * from "John Doe", "john@example.org" to "John Doe <john@example.org>".
	 *
	 * @param name string with name
	 * @param email string with email
	 * @return string with e-mail
	 */
	function emailify($name, $email) {
		return $name . " " . $this->wrapEmail($email);
	}

	/**
	 * Checks if mailer is working in test mode.
	 *
	 * @return bool
	 */
	function inTestMode() {
		return (bool)\F3::get('email_test_inbox');
	}

	/**
	 * Substitutes provided email with the test destination inbox, if Mailer
	 * set to work in test mode.
	 *
	 * @param email email provided as destination
	 * @return actual email that should be used
	 */
	protected function getRealToEmail($email) {
		return $this->inTestMode()
			? \F3::get('email_test_inbox')
			: $email;
	}

}
