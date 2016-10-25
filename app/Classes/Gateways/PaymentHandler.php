<?php

namespace App\Classes\Gateways;
use App\Classes\Gateways\Gateway;
use App\Classes\Card;
use App\Classes\Transaction;
use App\Classes\Models\PaymentGateway;
use Log;

class PaymentHandler {


	public function __construct(){

	}

	public function processCreditCard(Gateway $pgateway, Card $card, Transaction $transaction){
		// Save order to database
		$gateway_id = PaymentGateway::select('id')->where('gateway_name',$pgateway->name());

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