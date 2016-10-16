<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class BrainTreeIntegrationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBrainTreeSandboxPayment()
    {
        //$this->markTestSkipped('Takes too long. Comment out after refactoring');
        $this->json('POST', '/v1/processcreditcardbt', 
                ['nameOnCard' => 'John Doe',
                 'cardNumber' => '4032032531467923',
                 'creditCardCVV' => '012',
                 'creditCardType' => 'visa',
                 'cardExpireMonth' => '11',
                 'cardExpireYear' => '2021',
                 'amount' => '12',
                'currency' => 'THB'])
             ->seeJson([
                'success' => 'true',
                'state' => 'approved'
             ]);
    }
}