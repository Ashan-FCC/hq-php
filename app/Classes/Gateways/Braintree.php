<?php 

namespace App\Classes\Gateways;
use App\Classes\Card;
use App\Classes\Transaction;
use Braintree_Configuration;
use Braintree_Transaction;
use Braintree\Result\Error;
use Braintree\Result\Successful;
use Exception;
use Illuminate\Http\Response;


class Braintree implements Gateway {

	public function name(){
		return 'Braintree';
	}

	public function processCreditCard(Card $card,Transaction $transaction)
    {
        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId(env('braintree_merchant_id'));
        Braintree_Configuration::publicKey(env('braintree_public_key'));
        Braintree_Configuration::privateKey(env('braintree_private_key'));


        $result = Braintree_Transaction::sale([
            'amount' => $transaction->amount,
            'merchantAccountId' => env('braintree_merchant_id_'.$transaction->currency),
            'creditCard' => ['number'=> $card->cardnumber,
                             'expirationMonth'=>$card->month,
                             'expirationYear'=>$card->year,
                             'cvv'=>$card->cvv],
            'options' => [
            'submitForSettlement' => True,

            ]
        ]);
        $response = new Response();
        if(!$result->success){
            $errors = array();
            foreach($result->errors->deepAll() AS $error) {
            array_push($errors ,  $error->message);
            }
        
        return $response->setStatusCode(Response::HTTP_BAD_REQUEST, "Error at Paypal gateway")
                            ->setContent(['errors'=>$errors]);
           
        }else{
         return $response->setStatusCode(200)
                            ->setContent(['success'=>'Transaction completed using Braintree gateway.'] );
        }

        //return array('success' => 'Transaction completed using BrainTree gateway.');
        return view('index',['success'=>'Transaction completed using BrainTree gateway.']);
	}
	
}

?>