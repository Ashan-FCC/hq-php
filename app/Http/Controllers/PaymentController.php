<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Log;
use App\Classes\Validators\DataValidator;
use App\Classes\Validators\CardValidator;

use App\Classes\Card;
use App\Classes\Gateways\PaymentHandler;

use App\Classes\Gateways\Braintree;
use App\Classes\Gateways\Paypal;

use App\Classes\Models\Currency;
use App\Classes\Models\Restriction;

use App\Classes\Validators\Resources\SourceCodeResource;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function processCreditCard(Request $request){
        //var_dump($request);
        Log::info('Request received: ', ['Request'=>$request->all()]);
        $cardnumber = $request->input('cardNumber');
        $cvv = $request->input('creditCardCVV');
        $month = $request->input('cardExpireMonth');
        $year = $request->input('cardExpireYear');
        $holdername = $request->input('nameOnCard');
        $cardtype = $request->input('creditCardType');

        $Currency = $request->input('currency');
        $Amount = $request->input('amount');
 
        //check restrictions

        $card = new Card($cardnumber, $cardtype, $cvv, $holdername, $month, $year);
        $transaction = new \App\Classes\Transaction($Amount, $Currency);

        // Validate the card data.
        $cardvalidator = new CardValidator(new SourceCodeResource);
        $validator = new DataValidator($cardvalidator , $card);
        
        $err = $validator->validateCard();
        if(count($err) > 0){
            Log::error('Error validating data: ', ['Errors'=>$err]);
            return $this->sendError($err);
        }

        //Check the restrictions
        if(Restriction::restricted($cardtype, $Currency)){
            Log::error('Transaction restricted by Card type: ', ['Card'=>$cardtype , 'Currency'=>$Currency]);
            return $this->sendError(array("Card type $cardtype cannot be used for currency $Currency"));
        }

        // Find the payment channel.
        try{
            $currencyGateway = $this->getGatewayForChannel($Currency);
           
        }catch(\PDOException $ex){
            Log::error('Error happened '.$ex->getMessage());
            return $this->sendError(array('Something went wrong at our end. Please try again later.'));
        }

        try{
            $gateway = $currencyGateway->gateway;
            $channel = $gateway->gateway_name;
        }catch(\Exception $ex){
            Log::error('Error occurred trying to get the gateway for currency:'.$Currency."\n".$ex->getMessage());
            return $this->sendError(array('Whoops! Something went wrong. Check the currency type.'));
        }


        $gateway = "App\\Classes\\Gateways\\".$channel;
        $gateway = new $gateway();
        $handler = new PaymentHandler();
        $result = $handler->processCreditCard($gateway, $card, $transaction);
   
        return $result;

    }

    private function getGatewayForChannel($Currency){
        try{

            $c = Currency::where('currency_code',$Currency)->first();
           
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $c;
    }

    private function sendError($errors){
        $response = new Response();
        return $response->setStatusCode(Response::HTTP_BAD_REQUEST, "Bad payment Data")->setContent(['errors'=>$errors]);
    }

}
