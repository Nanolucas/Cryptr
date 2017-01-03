<?php
namespace AppBundle\Classes\Algorithm;

/**
 * Substitution of characters with other characters from a rotated alphabet
 * ROT1 = A -> B, B -> C
 * ROT2 = A -> C, B -> D etc.
 *
 * @package     Cryptr
 * @author      Luke Doherty <nanolucas@gmail.com>
 * @version     1.0
 */
class Rot extends Substitution {
	protected function create_substitution_alphabet($message_data) {
		//start with the standard english alphabet and split it into an array of characters
		$alphabet = str_split($this->alphabet);

		foreach ($alphabet as $character) {
			//get the ascii code of the current current character from the alphabet, then add the rotation number ("difficulty") to it
			$shifted_character_ascii_code = ord($character) + $this->difficulty;
			
			//let's work in a range of 0 - 25
			$shifted_character_ascii_code -= 65;

			//if we're outside that range we need to bring it back in
			if ($shifted_character_ascii_code < 0 || $shifted_character_ascii_code > 25) {
				//get the modulus of the number to bring it back within range
				$shifted_character_ascii_code = $shifted_character_ascii_code % 26;

				//unless it's negative, in which case add 26 again to get it back to the expected wrap-around value
				if ($shifted_character_ascii_code < 0) {
					$shifted_character_ascii_code += 26;
				}
			}

			//now let's make it back into a valid ascii code
			$shifted_character_ascii_code += 65;

			//and finally convert the ascii code back to a character we recognise
			$this->substitution_alphabet[$character] = chr($shifted_character_ascii_code);
		}
	}
}
