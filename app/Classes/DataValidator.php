<?php 

namespace App\Classes\Validators;

class DataValidator {

	public function validate($number){

	}

	public function validateCard($cardnumber, $expiremonth, $expireyear, $cardcvv){
		$errors = array();

		if(!ctype_digit($cardnumber))
		{
			array_push($errors , 'Card number should be numeric only');
		}
		if(!ctype_digit($cardcvv))
		{
			array_push($errors , 'CVV should be numeric only');
		}
		$today = date('mY');
		validateExpireDate($expiremonth, $expireyear);
		validateCardNumber();
		validateCardCVV();
	}

	public function validateCardNumber($cardnumber){

	}
}

?>