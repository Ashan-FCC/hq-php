<?php

namespace App\Http\Controllers;
use App\Classes\Models\CreditCardType;

class CreditCardController extends Controller
{
  
   	public function index(){
       
      $cards  = CreditCardType::all(); 
       return $cards;
    
  	}	

}
