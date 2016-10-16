<?php

namespace App\Classes\Gateways;
use Gateway;
use App\Classes\Card;
use App\Classes\Transaction;

class PaymentHandler {


	public function __construct(){

	}

	public function processCreditCard(Gateway $pgateway, Card $card, Transaction $transaction){
		// Save order to database

		// Do the payment
		$result = $pgateway->processCreditCard($card, $transaction);
	}

}
?>