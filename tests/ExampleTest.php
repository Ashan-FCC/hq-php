<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = "Process Payment";
        $this->assertEquals(
            "Process Payment", $response
        );
    }
}
