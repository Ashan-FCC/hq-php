<?php

namespace App\Classes\Validators\Resources;
use App\Classes\Validators\Resources\SpecificationResourceInterface;

class SourceCodeResource implements SpecificationResourceInterface{
	public function __construct(){

	}

	public function CardSpecification(){
		return array(
		        'default' => array(
		            'length' => '13,14,15,16,17,18,19',
		            'prefix' => '',
		            'luhn' => TRUE,
		        ),
		        'amex' => array(
		            'length' => '15',
		            'prefix' => '3[47]',
		            'luhn' => TRUE,
		        ),
		        'discover' => array(
		            'length' => '16',
		            'prefix' => '6(?:5|011)',
		            'luhn' => TRUE,
		        ),
		        'mastercard' => array(
		            'length' => '16',
		            'prefix' => '5[1-5]',
		            'luhn' => TRUE,
		        ),
		        'visa' => array(
		            'length' => '13,16',
		            'prefix' => '4',
		            'luhn' => TRUE,
		        ),
		    );

	}
}

?>