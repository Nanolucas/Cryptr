<?php
namespace AppBundle\Classes\Algorithm;

/**
 * Substitution of characters with morse code equivalents
 *
 * @package     Cryptr
 * @author      Luke Doherty <nanolucas@gmail.com>
 * @version     1.0
 */
class Morse extends Substitution {
	protected function create_substitution_alphabet($message_data) {
		$this->substitution_alphabet = [
			'A' => '.- ',
			'B' => '-... ',
			'C' => '-.-. ',
			'D' => '-.. ',
			'E' => '. ',
			'F' => '..-. ',
			'G' => '--. ',
			'H' => '.... ',
			'I' => '.. ',
			'J' => '.--- ',
			'K' => '-.- ',
			'L' => '.-.. ',
			'M' => '-- ',
			'N' => '-. ',
			'O' => '--- ',
			'P' => '.--. ',
			'Q' => '--.- ',
			'R' => '.-. ',
			'S' => '... ',
			'T' => '- ',
			'U' => '..- ',
			'V' => '...- ',
			'W' => '.-- ',
			'X' => '-..- ',
			'Y' => '-.-- ',
			'Z' => '--.. ',
			'0' => '----- ',
			'1' => '.---- ',
			'2' => '..--- ',
			'3' => '...-- ',
			'4' => '....- ',
			'5' => '..... ',
			'6' => '-.... ',
			'7' => '--... ',
			'8' => '---.. ',
			'9' => '----. ',
			'.' => '.-.-.- ',
			 ',' => '--..-- ',
			'?' => '..--.. ',
		];
	}
}
