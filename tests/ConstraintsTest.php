<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Classes\Models\Currency;
use App\Classes\Models\Restriction;

class ConstraintsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGatewayForUSD() 
    {
        $currency = "USD";
        $c = Currency::where('currency_code',$currency)->first();
        $gateway = $c->gateway;
        $this->assertEquals('Paypal' , $gateway->gateway_name);

    }
    public function testGatewayForEUR() 
    {
        $currency = "EUR";
        $c = Currency::where('currency_code',$currency)->first();
        $gateway = $c->gateway;
        $this->assertEquals('Paypal' , $gateway->gateway_name);

    }

    public function testGatewayForTHB(){
        $currency = "THB";
        $c = Currency::where('currency_code',$currency)->first();
        $gateway = $c->gateway;
        $this->assertEquals('Braintree' , $gateway->gateway_name);
    }

    public function testGatewayForSGD(){
        $currency = "SGD";
        $c = Currency::where('currency_code',$currency)->first();
        $gateway = $c->gateway;
        $this->assertEquals('Braintree' , $gateway->gateway_name);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testRestrictionsforVisaUSD($cardtype, $currency, $expected){
        $this->assertEquals($expected, Restriction::restricted($cardtype, $currency));
    }

    public function dataProvider(){
        return array(
          array('visa', 'EUR', false),
          array('mastercard', 'USD', false),
          array('amex', 'USD', true),
          array('amex', 'THB', false)
        );
    }
}
