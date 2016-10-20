<?php

use Illuminate\Database\Seeder;
use App\Classes\Models\CreditCardType;

class CreditCardTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$cards = ['visa', 'mastercard' , 'amex' , 'discover'];
    	foreach($cards as $card){
    		CreditCardType::create(['card_type'=>$card,
    								'created_at'=>new DateTime,
    								'updated_at'=>new DateTime]);
    	}
        $this->call('CreditCardTypesSeeder');
    }
}
