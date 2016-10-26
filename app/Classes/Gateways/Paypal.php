<?php 

namespace App\Classes\Gateways;
use App\Classes\Card;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use Log;
use App\Classes\Models\PaymentGateway;
use App\Classes\Models\CreditCardResponse;
use DateTime;
use DateTimeZone;

use Illuminate\Http\Response;
ini_set('max_execution_time', 120);

class Paypal implements Gateway {

	public function name(){
		return 'Paypal';
	}

    public function getId(){
        return PaymentGateway::getId($this->name())->id;
    }
	
	public function processCreditCard(Card $card , \App\Classes\Transaction $transaction){

        $response = new Response();
       // try{
           $apiContext = new ApiContext(
                    new OAuthTokenCredential(env('Paypal_ClientID'),  env('Paypal_ClientSecret'))); 
      /* }catch(Exception $ex){
        Log::critical('Error at paypal gateway: '.$ex->getMessage());
        return $response->setStatusCode(Response::HTTP_BAD_REQUEST, "Error at Paypal gateway")->setContent(['errors'=>'Oh no! Something  went wrong. Were trying to fix it now']);
       }*/
		

        $apiContext->setConfig(
                          array(
                            'log.LogEnabled' => true,
                            'log.FileName' => '../storage/logs/Paypal.log',
                            'log.LogLevel' => 'DEBUG',
                            'mode' => 'sandbox'
                          )
                        );
        $creditCard = new CreditCard();
        $card = $card->getHolderName();
        $creditCard->setType($card->cardtype)
                ->setNumber($card->cardnumber)
                ->setExpireMonth($card->month)
                ->setExpireYear($card->year)
                ->setCvv2($card->cvv)
                ->setFirstName($card->firstname)
                ->setLastName($card->lastname);

        $fi = new FundingInstrument();
        $fi->setCreditCard($creditCard);

        $payer = new Payer();
        $payer->setPaymentMethod("credit_card");
        $payer->setFundingInstruments(array($fi));


        $amount = new Amount();
        $amount->setCurrency($transaction->currency)
            ->setTotal($transaction->amount);


        $tr = new Transaction();
        $tr->setAmount($amount)
            ->setDescription("Payment description")
            ->setInvoiceNumber($transaction->invoiceid);

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($tr));
          
        
        try {

           $result = $payment->create($apiContext);
           
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            $result = $ex->getData();
            $errors = $this->getErrors($result);
            return $response->setStatusCode(Response::HTTP_BAD_REQUEST, "Error at Paypal gateway")
                            ->setContent(['errors'=>$errors]);
        }

        if(env('APP_ENV')==="local"){

            if(($result->state === 'approved' || $result->state === 'created') && $result->intent==='sale'){
                $this->storeData($result,$transaction, $card);
                Log::info("Success at PayPal");
                return $response->setStatusCode(200)
                                    ->setContent(['success'=>'Transaction completed using PayPal gateway.'] );
            }
        }else if(env('APP_ENV')==='production'){
            return $response->setStatusCode(400)
                                    ->setContent(['error'=>'Not ready for production yet. Check conditions.'] );
        }

        
	}

    private function getErrors($result){
        $errors = array();
        array_push($errors , json_decode($result)->message);
        return $errors;

    }

    private function storeData($result, $transaction, $card){
        $transactionId = $result->id;
        $status = $result->state;
        $type = $result->intent;
        $gatewayid = $this->getId();
        $orderId = $transaction->invoiceid;
 

        $last4 = substr($card->cardnumber, -4);
        $expire = $card->month . "/" . $card->year;

        $created_time = $result->create_time;
        $created_time = $this->formatDateTime($created_time);

        $updated_at = $result->update_time;
        $updated_at = $this->formatDateTime($updated_at);

        CreditCardResponse::create(['transaction_id'=>$transactionId,
                                    'transaction_type'=>$type,
                                    'transaction_status'=>$status,
                                    'gateway_id'=>$gatewayid,
                                    'invoice_id'=>$orderId,
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