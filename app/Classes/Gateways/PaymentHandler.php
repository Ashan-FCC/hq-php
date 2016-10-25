<?php

namespace App\Classes\Gateways;
use App\Classes\Gateways\Gateway;
use App\Classes\Card;
use App\Classes\Transaction;

class PaymentHandler {


	public function __construct(){

	}

	public function processCreditCard(Gateway $pgateway, Card $card, Transaction $transaction){
		// Save order to database

		// Do the payment
		try{
			$result = $pgateway->processCreditCard($card, $transaction);
		}catch(\Exception $ex){
			Log::critical('error occurred: '.$ex->getMessage());
			
			return view('index',['errors'=>array( $ex->getMessage())]);
		}

		return $result;
	}

}
?>