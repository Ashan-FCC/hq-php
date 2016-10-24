<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('CreditCardTypeSeeder');
        $this->call('PaymentGatewaySeeder');
        $this->call('CurrencySeeder');
        $this->call('RestrictionSeeder');
    }
}
