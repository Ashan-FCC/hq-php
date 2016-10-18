<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Classes\Validators\BaseCardValidator;
use App\Classes\Validators\CardValidator;

class BaseCardValidatorTest extends TestCase
{
    private $validator;

    public function setUp(){
        $this->validator = new CardValidator();
    }

    public function testCorrectValidExpireDate(){
        $res  = $this->validator->validateExpireDate('12' , '2018');
        $this->assertTrue(count($res)===0);
    }

    public function testCorrectValidateCVV(){
        $res  = $this->validator->validateCVV('018');
        $this->assertTrue(count($res)===0);
    }

    public function testCorrectValidateHolderName(){
        $res  = $this->validator->validateHolderName('John Doe');
        $this->assertTrue(count($res)===0);
    }
    
    public function testIncorrectValidExpireDate(){
        $res  = $this->validator->validateExpireDate('12' , '2015');
        $this->assertFalse(count($res)===0);
    }

    public function testIncorrectValidateCVV(){
        $res  = $this->validator->validateCVV('ASH');
        $this->assertFalse(count($res)===0);

        $res  = $this->validator->validateCVV('12');
        $this->assertFalse(count($res)===0);
    }

    public function testIncorrectValidateHolderName(){
        $res  = $this->validator->validateHolderName('JohnDoe');
        $this->assertFalse(count($res)===0);
    }

}
