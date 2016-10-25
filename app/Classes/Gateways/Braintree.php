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
use Log;


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

        try{

        $result = Braintree_Transaction::sale([
            'amount' => $transaction->amount,
            'merchantAccountId' => env('braintree_merchant_id_'.$transaction->currency),
            'creditCard' => ['number'=> $card->cardnumber,
                             'expirationMonth'=>$card->month,
                             'expirationYear'=>$card->year,
                             'cardholderName'=>$card->holdername,
                             'cvv'=>$card->cvv],
            'orderId' => $transaction->invoiceid,
            'options' => [
            'submitForSettlement' => True,

            ]
        ]);
        }catch(Exception $ex){
            Log::error('Error occured',['errors'=>$ex->getMessage()]);
        }

        try{

            $response = new Response();
            $errors = array();
            if(!$result->success) {
                
                foreach($result->errors->deepAll() AS $error) {
                array_push($errors ,  $error->message);
                }
            Log::info('Transaction failed at Braintree gateway',['errors'=>$errors]);
            return $response->setStatusCode(Response::HTTP_BAD_REQUEST, "Error at Braintree gateway")->setContent(['errors'=>$errors]);
               
            }else
            {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
            Log::info('Transaction success at Braintree gateway');
            $transaction = $result->transaction;
            echo $transaction;
            //$status = $transaction->
            return $response->setStatusCode(200)
                                ->setContent(['success'=>'Transaction completed using Braintree gateway.'] );
            }
        }catch(Exception $ex){
            Log::error('Error: '.$ex->getMessage());
            Log::error(json_encode($ex));
        }
	}
	
}

?>