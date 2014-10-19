<?php

namespace models;

class Mailer {

	function sendEmail($to, $subject, $message) {
		$smtp = new \SMTP(
			\F3::get('smtp_host'),
			\F3::get('smtp_port'),
			\F3::get('smtp_scheme'),
			\F3::get('smtp_user'),
			\F3::get('smtp_pass')
			);

		$smtp->set('From', $this->wrapEmail(\F3::get('email_from')));
		$smtp->set('Reply-To', $this->wrapEmail(\F3::get('email_reply_to')));
		$smtp->set('To', $this->wrapEmail($to));
		$smtp->set('Subject', $subject);

		$smtp->send($message);
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

}
