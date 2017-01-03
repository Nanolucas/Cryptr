<?php
namespace AppBundle\Classes;

/**
 * Regarding specific languages
 *
 * @category    Cryptr
 * @package     Cryptr
 * @author      Luke Doherty <nanolucas@gmail.com>
 * @version     1.0
 * http://www.cl.cam.ac.uk/~mgk25/lee-essays.pdf p181
 */
class Language {
	const ENGLISH = 1;
	
	private static $letter_frequency = [
		1 => [
			'e' => '12.70',
			't' => '9.06',
			'a' => '8.17',
			'o' => '7.51',
			'i' => '6.97',
			'n' => '6.75',
			's' => '6.33',
			'h' => '6.10',
			'r' => '5.99',
			'd' => '4.25',
			'l' => '4.03',
			'c' => '2.78',
			'u' => '2.76',
			'm' => '2.41',
			'w' => '2.36',
			'f' => '2.23',
			'g' => '2.02',
			'y' => '1.97',
			'p' => '1.93',
			'b' => '1.49',
			'v' => '0.98',
			'k' => '0.77',
			'j' => '0.15',
			'x' => '0.15',
			'q' => '0.10',
			'z' => '0.07',
		],
	];
	
	public static function get_language_letter_frequency($language_id) {
		if (!array_key_exists($language_id, self::$letter_frequency)) {
			throw new \InvalidArgumentException("Language ID #{$language_id} not supported for letter frequencies");
		}
		
		return self::$letter_frequency[$language_id];
	}
	
	public static function get_letter_frequency($phrase) {
		$letter_counts = count_chars($phrase, 1);
		$phrase_length = strlen($phrase);
		$frequencies = [];

		foreach ($letter_counts as $letter => $count) {
			$frequencies[chr($letter)] = round($count / $phrase_length * 100, 2) . '';
		}

		//show results in descending frequency order
		arsort($frequencies, SORT_NUMERIC);
		
		return $frequencies;
	}
}
