<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Classes\Validators\Resources\SpecificationResourceInterface;
use App\Classes\Validators\Resources\SourceCodeResource;

class CardResourceTest extends TestCase
{
    private $cardarray;
    public function setUp(){
        $scResource = new SourceCodeResource;
        $this->cardarray = $this->getCardSpecification($scResource);     
    }
    
    public function testSourceCodeResourceHasCards(){
        $this->assertTrue(isset($this->cardarray['visa']));
        $this->assertTrue(isset($this->cardarray['amex']));
        $this->assertTrue(isset($this->cardarray['mastercard']));
    }

    private function getCardSpecification(SpecificationResourceInterface $resource){
        return $resource->CardSpecification();
    }

}
