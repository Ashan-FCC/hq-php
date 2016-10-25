<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditCardResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CreditCardResponses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id');
            $table->string('transaction_type');
            $table->string('transaction_status');
            $table->integer('gateway_id')->unsigned()->index();
            $table->string('invoice_id')->unsigned()->index();
            $table->integer('cardnumber_last4_digits');
            $table->string('cardtype');
            $table->string('cardexpire');
            $table->string('cardholder_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('CreditCardResponses');
    }
}
