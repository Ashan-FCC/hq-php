<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classes\Validators\DataValidator;

use App\Classes\Card;
use App\Classes\Gateways\PaymentHandler;

use App\Classes\Gateways\Braintree;
use App\Classes\Gateways\Paypal;

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

    public function processCreditCardbt(Request $request){
        $cardnumber = $request->input('cardNumber');
        $cvv = $request->input('creditCardCVV');
        $month = $request->input('cardExpireMonth');
        $year = $request->input('cardExpireYear');
        $holdername = $request->input('nameOnCard');
        $cardtype = $request->input('creditCardType');

        $Currency = $request->input('currency');
        $Amount = $request->input('amount');

        $Currency = $request->input('currency');
        $Amount = $request->input('amount');

        $card = new Card($cardnumber, $cardtype, $cvv, $holdername, $month, $year);
        $transaction = new \App\Classes\Transaction($Amount, $Currency);

        $gateway = new Braintree();

        $handler = new PaymentHandler();
        $result = $handler->processCreditCard($gateway, $card, $transaction);
        return $result;
        return response($result)
            ->withHeaders([
                'Content-Type' => 'application/json']);

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


        // Find the payment channel.

        // Validate the card data.

       // $validator = new DataValidator();
        $gateway = new Paypal();
        $handler = new PaymentHandler();
        $result = $handler->processCreditCard($gateway, $card, $transaction);
   
        return $result;

    }

    public function firstcall(Request $request){
    $apiContext = new ApiContext(
                    new OAuthTokenCredential(env('Paypal_ClientID'),  env('Paypal_ClientSecret')));

    $apiContext->setConfig(
                          array(
                            'log.LogEnabled' => true,
                            'log.FileName' => 'PayPal.log',
                            'log.LogLevel' => 'DEBUG',
                            'mode' => 'sandbox'
                          )
                        );


    $creditCard = new CreditCard();
    $creditCard->setType("visa")
                ->setNumber("4032032531467923")
                ->setExpireMonth("11")
                ->setExpireYear("2021")
                ->setCvv2("012")
                ->setFirstName("Joe")
                ->setLastName("Shopper");

    try {
        $result = $creditCard->create($apiContext);
        }
        catch (PayPalConnectionException $ex) {
        $result = $ex->getData();
        }
        return $result;
        //$this->testTransaction($apiContext , $result);




        //$this->makePayment($apiContext, $card);
    }

    private function testTransaction($apiContext , $creditCard){
        $fi = new FundingInstrument();
        $fi->setCreditCard($creditCard);

        $payer = new Payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));
        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
            ->setDescription('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setTax(0.3)
            ->setPrice(7.50);
        $item2 = new Item();
        $item2->setName('Granola bars')
            ->setDescription('Granola Bars with Peanuts')
            ->setCurrency('USD')
            ->setQuantity(5)
            ->setTax(0.2)
            ->setPrice(2);

        $itemList = new ItemList();
        $itemList->setItems(array($item1, $item2));

        $details = new Details();
        $details->setShipping(1.2)
            ->setTax(1.3)
            ->setSubtotal(17.5);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(20)
        ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        try {
           $result = $payment->create($apiContext);
           echo "<br>Payment Result";
           var_dump($result);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getData();
            echo $ex->getCode();
            // var_dump($ex);
            // die($ex);
        }

    }
    //
    private function makePayment($apiContext , $card){

        $fi = new FundingInstrument();
        $fi->setCreditCard($card);
        $payer = new Payer();
        $payer->setPaymentMethod("credit_card")
                ->setFundingInstruments(array($fi));

        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
                ->setDescription('Ground Coffee 40 oz')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setTax(0.3)
                ->setPrice(7.50);
                
        $item2 = new Item();
        $item2->setName('Granola bars')
                ->setDescription('Granola Bars with Peanuts')
                ->setCurrency('USD')
                ->setQuantity(5)
                ->setTax(0.2)
                ->setPrice(2);

        $itemList = new ItemList();
        $itemList->setItems(array($item1, $item2));

        $details = new Details();
        $details->setShipping(1.2)
            ->setTax(1.3)
            ->setSubtotal(17.5);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(20)
            ->setDetails($details);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));
          //  var_dump($payment);
    //     $request = clone $payment;

        try {
            $result = $payment->create($apiContext);
        } catch (PayPalConnectionException $ex) {
           echo "Exception<br>";
           echo $ex->getMessage();
           var_dump($ex);
           die();
        }
         echo "<br>Result<br>";
         echo $result;
    //     var_dump($result);
    //     echo "payment<br>";
    //     var_dump($payment);
    // 
        }
}
