<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Classes\Gateways\Paypal;
use App\Classes\Gateways\Braintree;
use App\Classes\Gateways\Gateway;
use App\Classes\Models\Currency;

class PaymentGatewayInterfaceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGatewayInterfaceNameforUSD()
    {
        $path = "App\\Classes\\Gateways\\";
        $channel = $this->getGatewayNamefromCurrency('USD');
        $gateway = $path.$channel;
        $paypal = new $gateway();
        $this->assertEquals('Paypal' , $this->getGatewayName($paypal));
    }

    public function testGatewayInterfaceNameforTHB(){
        $path = "App\\Classes\\Gateways\\";
        $channel = $this->getGatewayNamefromCurrency('THB');
        $gateway = $path.$channel;
        $braintree = new $gateway();
        $this->assertEquals('Braintree' , $this->getGatewayName($braintree));
    }

    private function getGatewayName(Gateway $pg){
        return $pg->name();
    }
    private function getGatewayNamefromCurrency($currency){
        $c = Currency::where('currency_code',$currency)->first();
        $gateway = $c->gateway;
        $channel = $gateway->gateway_name;
        return $channel;
    }
}
