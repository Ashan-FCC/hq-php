<?php 

namespace App\Classes\Gateways;
use App\Classes\Card;


class Braintree implements Gateway {

	public function name(){
		return 'Braintree';
	}

	public function processCreditCard(Card $card,Transaction $transaction){

        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId(env('braintree_merchant_id'));
        Braintree_Configuration::publicKey(env('braintree_public_key'));
        Braintree_Configuration::privateKey(env('braintree_private_key'));

        $result = Braintree_Transaction::sale([
            'amount' => $transaction->amount,
            'merchantAccountId' => env('braintree_merchant_id_'.$transaction->currency),
            'creditCard' => ['number'=> $card->cardnumber,
                             'expirationMonth'=>$card->month,
                             'expirationYear'=>$card->year,
                             'cvv'=>$card->cvv],
            'options' => [
            'submitForSettlement' => True
            ]
        ]);
        return $result;
	}
	
}

?>