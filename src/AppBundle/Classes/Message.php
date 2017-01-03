<?php
namespace AppBundle\Classes;

/**
 * Process a phrase into an encoded message
 *
 * @package     Cryptr
 * @author      Luke Doherty <nanolucas@gmail.com>
 * @version     1.0
 */
class Message {
	private $raw_message;
	private $encoded_message;

	public function __construct($message) {
		$this->raw_message = strtoupper($message);
	}

	public static function get() {
		$message = Session::get('message');

		if (is_null($message)) {
			throw new \BadMethodCallException('Message has not been set');
		}

		return new self($message);
	}

	public static function set($message) {
		Session::set('message', $message);

		return new self($message);
	}

	public function encode($algorithm, $difficulty = 1, $id = null) {
		$class_name = 'AppBundle\\Classes\\Algorithm\\' . $algorithm;
		$encoder = new $class_name();

		$this->encoded_message = $encoder->difficulty($difficulty)->process($this->raw_message, $id);

		return $this;
	}

	public function output() {
		if (is_null($this->encoded_message)) {
			throw new \BadMethodCallException('Message has not been encoded yet');
		}

		return str_split($this->encoded_message);
	}

	public function check_answer($answer) {
		$answer = trim(strtolower($answer));

		return ($answer == trim(strtolower($this->raw_message)));
	}
}
