<?php
namespace AppBundle\Classes\Algorithm;

/**
 * Interface for each encryption algorithm
 *
 * @package     Cryptr
 * @author      Luke Doherty <nanolucas@gmail.com>
 * @version     1.0
 */
interface AlgorithmInterface {
	//set the difficulty level of the encryption
	public function difficulty($level);
	
	//encode the message with the given algorithm
	public function process($message, $id = null);
}