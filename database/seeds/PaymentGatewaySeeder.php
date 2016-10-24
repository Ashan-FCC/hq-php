<?php

use Illuminate\Database\Seeder;
use App\Classes\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$gateways = ['Paypal', 'Braintree'];
    	foreach($gateways as $gateway){
    		PaymentGateway::create(['gateway_name'=>$gateway,
    								'created_at'=>new DateTime,
    								'updated_at'=>new DateTime]);
    	}
    }
}
