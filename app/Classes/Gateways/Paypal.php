<?php 

namespace App\Classes\Gateways;
use App\Classes\Card;

class Paypal implements Gateway {

	public function name(){
		return 'Paypal';
	}
	
	public function processCreditCard(Card $card , Transaction $transaction){

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
        $creditCard->setType($card->type)
                ->setNumber($card->cardnumber)
                ->setExpireMonth($card->month)
                ->setExpireYear($card->year)
                ->setCvv2($card->cvv)
                ->setFirstName($first)
                ->setLastName($last);

                	 = $cardnumber;
		$this= $cardtype;
		$this->cvv = $cvv;
		$this->holdername = $holdername;
		$this->month = $month;
		$this->year = $year;

        $fi = new FundingInstrument();
        $fi->setCreditCard($creditCard);

        $payer = new Payer();
        $payer->setPaymentMethod("credit_card");
        $payer->setFundingInstruments(array($fi));


        $amount = new Amount();
        $amount->setCurrency($Currency)
            ->setTotal($Amount);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));
           
        try {
           $result = $payment->create($apiContext);
           echo "<br>Payment Result";

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getData();
            echo $ex->getCode();
            $result = $ex->getData();
        }
	}

}

?>