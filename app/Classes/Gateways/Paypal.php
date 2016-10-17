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

class Paypal implements Gateway {

	public function name(){
		return 'Paypal';
	}
	
	public function processCreditCard(Card $card , \App\Classes\Transaction $transaction){

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
           echo "<br>Payment Result";

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getData();
            echo $ex->getCode();
            $result = $ex->getData();
        }

        return $result;
	}

}

?>