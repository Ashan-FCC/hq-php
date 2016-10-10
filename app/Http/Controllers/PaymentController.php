<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function processpayment(Request $request){
        var_dump($request->input());
        die();

    }

    //
}
