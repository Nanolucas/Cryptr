<?php
namespace AppBundle\Classes\Algorithm;

/**
 * Substitution of characters with other characters from a randomised alphabet
 *
 * @package     Cryptr
 * @author      Luke Doherty <nanolucas@gmail.com>
 * @version     1.0
 */
class RandomSubstitution extends Substitution {
	protected $extended_alphabet = '0123456789!@#$%&*+-=?<>\'".,:;';
	
	protected function create_substitution_alphabet($message_data) {
		$available_characters = $this->alphabet;

		//throw additional symbols in if we want to make it harder
		if ($this->difficulty == 2) {
			$available_characters .= $this->extended_alphabet;
		}

		$new_alphabet = str_split($available_characters);

		//randomise the character order
		shuffle($new_alphabet);

		//find each unique character in the message
		$alphabet = array_values(array_unique($message_data));

		//this will substitute each character from the message (including punctuation) for one from the new alphabet
		//if the character does not exist within the new alphabet, it won't be changed
		$this->substitution_alphabet = [];
		foreach ($alphabet as $index => $character) {
			if (in_array($character, $new_alphabet)) {
				$this->substitution_alphabet[$character] = $new_alphabet[$index];
			}
		}
	}
}
