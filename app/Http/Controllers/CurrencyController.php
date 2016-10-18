<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Classes\Models\Currency;

class CurrencyController extends Controller
{
 
 	public function index(){
       
       $currencies = Currency::all();
       return $gateways;
    
  	}	

  
}
