<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Amount;
<<<<<<< HEAD
=======
use PayPal\Api\CreditCard;
>>>>>>> 7da9d7a723c53fa00fa3f6fa1007887fa17ef37a
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
<<<<<<< HEAD
=======

>>>>>>> 7da9d7a723c53fa00fa3f6fa1007887fa17ef37a

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
        return "Process Payment";

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

<<<<<<< HEAD
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
        echo $ex->getData();
        }
        $this->testTransaction($apiContext , $result);
=======
    $card = new CreditCard();
    $card->setType("via");
    $card->setNumber("4032032531467923");
    $card->setExpireMonth("11");
    $card->setExpireYear("2021");
    $card->setFirstName("Joe");
    $card->setLastName("Shopper");

    // try {
    //     $creditCard->create($apiContext);
    //     echo $creditCard;
    //     }
    //     catch (PayPalConnectionException $ex) {
    //     echo $ex->getData();

    //     }

        $this->makePayment($apiContext, $card);
>>>>>>> 7da9d7a723c53fa00fa3f6fa1007887fa17ef37a

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
