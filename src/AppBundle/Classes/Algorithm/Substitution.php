<?php
namespace AppBundle\Classes\Algorithm;
use AppBundle\Classes\Session;

/**
 * Substitution of characters with other characters
 *
 * @package     Cryptr
 * @author      Luke Doherty <nanolucas@gmail.com>
 * @version     1.0
 */
abstract class Substitution implements AlgorithmInterface {
	protected $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	protected $difficulty = 1;
	protected $substitution_alphabet;

	public function difficulty($level) {
		$this->difficulty = $level;

		return $this;
	}

	public function process($message, $id = null) {
		$message_data = str_split($message);

		if (!empty($id)) {
			$this->substitution_alphabet = Session::get("alphabet_{$id}");
		}
		
		if (is_null($this->substitution_alphabet)) {
			$this->create_substitution_alphabet($message_data);
		}

		if (!empty($id)) {
			Session::set("alphabet_{$id}", $this->substitution_alphabet);
		}

		//now lets convert the characters from the message into the new alphabet
		$new_message_data = array();
		foreach ($message_data as $index => $character) {
			if (array_key_exists($character, $this->substitution_alphabet)) {
				$new_message_data[$index] = $this->substitution_alphabet[$character];
			} else {
				$new_message_data[$index] = $character;
			}
		}

		return implode($new_message_data);
	}

	abstract protected function create_substitution_alphabet($message_data);
}
