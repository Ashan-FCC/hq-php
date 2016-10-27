<?php 

namespace App\Classes\Gateways;
use App\Classes\Card;
use App\Classes\Transaction;
use App\Classes\Models\PaymentGateway;
use Braintree_Configuration;
use Braintree_Transaction;
use Braintree\Result\Error;
use Braintree\Result\Successful;
use Exception;
use Illuminate\Http\Response;
use Log;
use App\Classes\Models\CreditCardResponse;
use DateTime;
use DateTimeZone;


class Braintree implements Gateway {

	public function name(){
		return 'Braintree';
	}

    public function getId(){
        return PaymentGateway::getId($this->name())->id;
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
           // $this->prettyPrint($result);
            $this->storeData($result->transaction, $transaction, $card);
            Log::info('Transaction success at Braintree gateway');

            return $response->setStatusCode(200)
                                ->setContent(['success'=>'Transaction completed using Braintree gateway.'] );
            }
        }catch(Exception $ex){
            Log::error('Error: '.$ex->getMessage());
            Log::error(json_encode($ex));
        }
	}
    private function prettyPrint($result){
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }

    private function storeData($result , $transaction, $card){
        $transactionId = $result->id;
        $status = $result->status;
        $type = $result->type;
        $gatewayid = $this->getId();

        $orderId = $transaction->invoiceid;

        $last4 = substr($card->cardnumber, -4);
        $expire = $card->month . "/" . $card->year;   

        $createdAt = $result->createdAt;//->date;
        $created_time = $this->formatDateTime($createdAt->format('Y-m-d H:i:s'));   

        $updated_at = $result->updatedAt;//->date;
        $updated_at = $this->formatDateTime($updated_at->format('Y-m-d H:i:s'));

        CreditCardResponse::create(['transaction_id'=>$transactionId,
                                    'transaction_type'=>$type,
                                    'transaction_status'=>$status,
                                    'gateway_id'=>$gatewayid,
                                    'invoice_id'=>$orderId,
                                    'sale_id' => "-",
                                    'cardnumber_last4_digits'=>$last4,
                                    'cardtype'=>$card->cardtype,
                                    'cardexpire'=>$expire,
                                    'cardholder_name'=>$card->holdername,
                                    'created_at'=>$created_time,
                                    'updated_at'=>$updated_at
                                    ]);



    }

    private function formatDateTime($datetime){
        $given = new DateTime($datetime, new DateTimeZone("UTC"));
        $given->setTimezone(new DateTimeZone("Asia/Bangkok"));
        $output = $given->format("Y-m-d H:i:s"); 
        return new DateTime($output);
    }

	
}

?>