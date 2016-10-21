<?php

namespace App\CLasses\Validators;

abstract class BaseTransactionValidator  {

	protected function validateAmount($amount){
		return $amount > 0 ;
	}
	abstract protected function validateCurrency($currency);
}