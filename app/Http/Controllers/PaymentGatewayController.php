<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Classes\Models\PaymentGateway;

class PaymentGatewayController extends Controller
{
    
    public function index(){
        $gateways = PaymentGateway::all();
        return $gateways;
    
  }

}
