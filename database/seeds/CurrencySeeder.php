<?php

use Illuminate\Database\Seeder;
use App\Classes\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$currencies = ['USD'=>1, 'EUR'=>1 , 'AUD'=>1 , 'THB'=>2, 'SGD'=>2, 'HKD'=>2];
    	foreach($currencies as $code=>$gateway){
    		Currency::create(['currency_code'=>$code,
                                    'gateway_id' =>$gateway,
    								'created_at'=>new DateTime,
    								'updated_at'=>new DateTime]);
    	}
    }
}
