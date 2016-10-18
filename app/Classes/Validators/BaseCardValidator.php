<?php 

namespace App\Classes\Validators;
use DateTime;

abstract class BaseCardValidator{



	abstract protected function validateCardNumber($cardnumber);

	public function validateExpireDate($month, $year){
		$errors = array();
		if(!ctype_digit($month)) array_push($errors, "Card expire month should be numeric format"); 
		if(!ctype_digit($year)) array_push($errors, "Card expire year should be numeric format");
		if(strlen($month) != 2) array_push($errors, "Card expire month should be MM format");
		if(strlen($year) != 4) array_push($errors, "Card expire year should be YYYY format");

		$format = "mY";
		$timenow  = DateTime::createFromFormat($format, date('mY'));
		$carddate  = DateTime::createFromFormat($format, $month.$year);  

		if($carddate <= $timenow) array_push($errors, "Card has already expired");
		return $errors;
	}

	public function validateCVV($cvv){
		$err  = array();
		if(!ctype_digit($cvv)) array_push($err, "Card CVV should be numeric format");
		if(strlen($cvv) < 3) array_push($err, "Card CVV should be atleast 3 characters long");
		return $err;
	}

	public function validateHolderName($holdername){
		$err  = array();
		$holdername = trim($holdername);
		if( strlen($holdername) === 0 ) {
			array_push($err, "Card holder name cannot be empty.");
		}
		if(count(explode(" ",$holdername)) < 2){
			array_push($err, "Card holder must have first name and second name.");
		}
		return $err;
		}



}