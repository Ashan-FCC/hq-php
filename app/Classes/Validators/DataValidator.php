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

	public function validateTransaction(Transaction $tr, $customerName){
		$err = array();
		if($tr->amount < env('min_transaction') ) {
			 array_push($err, 'Minimum transaction amount must be greater than '.env('min_transaction'));
		}
		$customerName = trim($customerName);
		if( strlen($customerName) === 0 ) {
			array_push($err, "Customer name cannot be empty.");
		}
		return $err;
	}

	// }

}

?>