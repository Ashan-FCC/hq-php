<?php
namespace App\Classes\Validators;
use App\Classes\Validators\BaseCardValidator;
use App\Classes\Validators\Resources\SpecificationResourceInterface;


class CardValidator extends BaseCardValidator {
	private $cardarray;

	public function __construct(SpecificationResourceInterface $resource){
		$this->cardarray = $resource->CardSpecification();
	
	}
	
	protected function luhn($number)
	{
	    // Force the value to be a string as this method uses string functions.
	    // Converting to an integer may pass PHP_INT_MAX and result in an error!
	    $number = (string)$number;

	    if (!ctype_digit($number)) {
	        // Luhn can only be used on numbers!
	        return FALSE;
	    }

	    // Check number length
	    $length = strlen($number);

	    // Checksum of the card number
	    $checksum = 0;

	    for ($i = $length - 1; $i >= 0; $i -= 2) {
	        // Add up every 2nd digit, starting from the right
	        $checksum += substr($number, $i, 1);
	    }

	    for ($i = $length - 2; $i >= 0; $i -= 2) {
	        // Add up every 2nd digit doubled, starting from the right
	        $double = substr($number, $i, 1) * 2;

	        // Subtract 9 from the double where value is greater than 10
	        $checksum += ($double >= 10) ? ($double - 9) : $double;
	    }

	    // If the checksum is a multiple of 10, the number is valid
	    return ($checksum % 10 === 0);
	}

public function validateCardNumber($number , $type = 'default')
{
    

    // Remove all non-digit characters from the number
    if (($number = preg_replace('/\D+/', '', $number)) === '')
        return FALSE;

    $cards = $this->cardarray;

    // Check card type
    $type = strtolower($type);

    if (!isset($cards[$type])){

        return array('This card type is not available');
    }

    // Check card number length
    $length = strlen($number);

    // Validate the card length by the card type
    if (!in_array($length, preg_split('/\D+/', $cards[$type]['length']))){

        return array('Invalid length for cardnumber');
    }

    // Check card number prefix
    if (!preg_match('/^' . $cards[$type]['prefix'] . '/', $number)){

       return array('Invalid cardnumber for type: '.$type);
    }

    // No Luhn check required
    if ($cards[$type]['luhn'] == FALSE)
        return array();

    if(!$this->luhn($number)){
    	return array('Card number is not verfied.');
    }

}
}