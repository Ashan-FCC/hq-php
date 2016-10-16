<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Classes\Models\PaymentGateway;

class PaymentGatewayController extends Controller
{
    
    public function index(){
        $gateways = PaymentGateway::all();
        return $gateways;
    
  }

}
