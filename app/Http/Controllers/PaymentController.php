<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\Validators\DataValidator;
use App\Classes\Validators\CardValidator;

use App\Classes\Card;
use App\Classes\Gateways\PaymentHandler;

use App\Classes\Gateways\Braintree;
use App\Classes\Gateways\Paypal;

use App\Classes\Models\Currency;

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
        $cardvalidator = new CardValidator();
        $validator = new DataValidator($cardvalidator , $card);
        
        $err = $validator->validateCard();
        if(count($err) > 0){
            return view('index',['errors'=>$err]);
        }

        //Check the restrictions


        // Find the payment channel.
        try{
            $currencyGateway = $this->getGatewayForChannel($Currency);
           
        }catch(\PDOException $ex){
            return view('index',['errors'=>array('Database error. Please check your settings.', $ex->getMessage())]);
        }

        try{
            $gateway = $currencyGateway->gateway;
            $channel = $gateway->gateway_name;
        }catch(\Exception $ex){
            return view('index',['errors'=>array( 'Whoops! Something went wrong. Check the database foreign id keys and models')]);
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

}
