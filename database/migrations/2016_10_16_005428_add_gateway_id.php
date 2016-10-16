<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGatewayId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Currency', function (Blueprint $table) {
            //
            $table->integer('payment_gateway_id')->after('currency_code')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Currency', function (Blueprint $table) {
            //
              $table->dropColumn('payment_gateway_id');
        });
    }
}
