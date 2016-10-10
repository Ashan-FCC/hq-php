<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\CreditCard;
use PayPal\Exception\PayPalConnectionException;

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

    public function processpayment(Request $request){
        var_dump($request->input());
        die();

    }

    public function firstcall(Request $request){
    $apiContext = new ApiContext(
                    new OAuthTokenCredential(env('Paypal_ClientID'),  env('Paypal_ClientSecret')));

    $apiContext->setConfig(
                          array(
                            'log.LogEnabled' => true,
                            'log.FileName' => 'PayPal.log',
                            'log.LogLevel' => 'DEBUG'
                          )
                        );

    $creditCard = new CreditCard();
    $creditCard->setType("visa")
                ->setNumber("4417119669820331")
                ->setExpireMonth("11")
                ->setExpireYear("2019")
                ->setCvv2("012")
                ->setFirstName("Joe")
                ->setLastName("Shopper");

    try {
        $creditCard->create($apiContext);
        echo $creditCard;
        }
        catch (PayPalConnectionException $ex) {
        echo $ex->getData();

        }

    }

    //
}
