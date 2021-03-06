<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class PaymentIntegrationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSuccessfulPaypalSandboxPayment()
    {
        $this->markTestSkipped('Takes too long. Comment out after refactoring');
        $this->json('POST', '/v1/processcreditcard', 
                ['nameOnCard' => 'John Doe',
                 'cardNumber' => '4032032531467923',
                 'creditCardCVV' => '012',
                 'creditCardType' => 'visa',
                 'cardExpireMonth' => '11',
                 'cardExpireYear' => '2021',
                 'amount' => '12',
                'currency' => 'USD'])
             ->seeJson([
                'intent' => 'sale',
                'state' => 'approved'
             ]);
    }

    public function testSuccessfulBrainTreeSandboxPayment()
    {
        $this->markTestSkipped('Takes too long. Comment out after refactoring');
        $this->json('POST', '/v1/processcreditcard', 
                ['nameOnCard' => 'John Doe',
                 'cardNumber' => '4111111111111111',
                 'creditCardCVV' => '012',
                 'creditCardType' => 'visa',
                 'cardExpireMonth' => '11',
                 'cardExpireYear' => '2021',
                 'amount' => '12',
                'currency' => 'THB'])
             ->seeJson([
                'success' => true
             ]);
    }
}

?>
