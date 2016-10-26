<?php

namespace App\Classes\Gateways;
use App\Classes\Gateways\Gateway;
use App\Classes\Card;
use App\Classes\Transaction;
use App\Classes\Models\PaymentGateway;
use App\Classes\Models\Order;
use Log;
use DateTime;

class PaymentHandler {


	public function __construct(){

	}

	public function processCreditCard(Gateway $pgateway, Card $card, Transaction $transaction){
		// Save order to database
		$gateway_id = PaymentGateway::select('id')->where('gateway_name',$pgateway->name());
		Order::create(['invoice_id'=>$transaction->invoiceid,
						'amount' => $transaction->amount,
						'currency_code'=>$transaction->currency,
    					'created_at'=>new DateTime,
    					'updated_at'=>new DateTime]);

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