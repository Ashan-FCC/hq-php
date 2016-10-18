<?php
namespace App\Classes\Validators;
use App\Classes\Validators\BaseCardValidator;

class CardValidator extends BaseCardValidator {
	public function __construct(){

	}
	public function validateCardNumber($cardnumber){
		//return array("Tets Error Validate Cardnumber");
		return array();
	}
}