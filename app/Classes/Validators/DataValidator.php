<?php 

namespace App\Classes\Validators;

use App\Classes\Validators\CardValidatorInterface;
use App\Classes\Card;

class DataValidator {

	private $validateInterface;
	private $card ;
	private $errors;

	public function __construct(CardValidatorInterface $type , Card $card){
		$this->validateInterface = $type;
		$this->card = $card;
		$this->errors = array();
	}

	public function validateCard(){

		
		$this->validateInterace->validateCardNumber();
		$this->validateCardExpire();
		$this->validateCVV();


	}

	// public function validateCard($cardnumber, $expiremonth, $expireyear, $cardcvv){
	// 	$errors = array();

	// 	if(!ctype_digit($cardnumber))
	// 	{
	// 		array_push($errors , 'Card number should be numeric only');
	// 	}
	// 	if(!ctype_digit($cardcvv))
	// 	{
	// 		array_push($errors , 'CVV should be numeric only');
	// 	}	
	// }

}

?>