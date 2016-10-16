<?php

namespace App\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Models\PaymentGateway;

class Currency extends Model {

protected $table ="Currency";

	public function paymentGateway(){

		return $this->belongsTo(PaymentGateway::class , 'payment_gateway_id', 'id');

	}


}

?>