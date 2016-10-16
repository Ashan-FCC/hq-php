<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Classes\Gateways\Paypal;
use App\Classes\Gateways\Braintree;
use App\Classes\Gateways\Gateway;

class PaymentGatewayTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGatewayInterfaceName()
    {
        $pp = 'App\Classes\Gateways\Paypal';
        $bt = 'App\Classes\Gateways\Braintree';

        $paypal = new $pp();
        $btclass = new $bt();

        $this->assertEquals('Paypal' , $this->getGatewayName($paypal));
        $this->assertEquals('Braintree' , $this->getGatewayName($btclass));

    }

    public function getGatewayName(Gateway $pg){
        return $pg->name();
    }
}
