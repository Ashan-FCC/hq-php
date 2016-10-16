<?php

namespace App\Classes;

class Transaction {

public $amount;
public $currency;
public $invoiceid;

	public function __construct($amount, $currency){
		$this->amount = $amount;
		$this->currency = $currency;
		$this->invoiceid = uniqid();
	}
	
}

?>