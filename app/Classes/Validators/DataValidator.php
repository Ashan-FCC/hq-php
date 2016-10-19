<?php 

namespace App\Classes\Validators;

use App\Classes\Card;
use App\Classes\Validators\BaseCardValidator;

class DataValidator {

	private $validateInterface;
	private $card ;
	private $errors;

	public function __construct(BaseCardValidator $type , Card $card){
		$this->validateInterface = $type;
		$this->card = $card;
		$this->errors = array();
	}

	public function validateCard(){

		$res1 = $this->validateInterface->validateCardNumber($this->card->cardnumber, $this->card->cardtype);
		$res2 = $this->validateInterface->validateExpireDate($this->card->month, $this->card->year);
		$res3 = $this->validateInterface->validateCVV($this->card->cvv);
		$res4 = $this->validateInterface->validateHolderName($this->card->holdername);
		$this->errors = array_merge($res1, $res2, $res3, $res4);
		return $this->errors;

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