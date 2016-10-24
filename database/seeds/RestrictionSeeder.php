<?php

use Illuminate\Database\Seeder;
use App\Classes\Models\Restriction;

class RestrictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		Restriction::create(['card_type'=> 'amex',
                                 'currency_code'=>'USD',
    							 'created_at'=>new DateTime,
    							 'updated_at'=>new DateTime]);
    	
    }
}
