<?php 

namespace App\Classes\Validators;

use App\Classes\Card;
use App\Classes\Transaction;
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

	public function validateTransaction(Transaction $tr){


	}

	// }

}

?>