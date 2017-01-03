<?php
namespace AppBundle\Classes\Algorithm;

/**
 * Show the message...backwards
 *
 * @package     Cryptr
 * @author      Luke Doherty <nanolucas@gmail.com>
 * @version     1.0
 */
class Backwards implements AlgorithmInterface {
	private $difficulty = 1;

	public function difficulty($level) {
		$this->difficulty = $level;

		return $this;
	}

	public function process($message, $id = null) {
		if ($this->difficulty == 1) {
			//simply return the whole string in reverse
			$encoded_message = strrev($message);
		} else if ($this->difficulty == 2) {
			//rearrange the order of all the words
			$words = explode(' ', $message);
			
			$words = array_reverse($words);
			
			$encoded_message = trim(implode(' ', $words));
		} else if ($this->difficulty == 3) {
			//reverse the order of the letters in each word but keep the original word order
			$encoded_message = '';
			
			$words = explode(' ', $message);
			
			foreach ($words as $word) {
				$encoded_message .= strrev($word) . ' ';
			}
			
			$encoded_message = trim($encoded_message);
		}

		return $encoded_message;
	}
}
