<?php

namespace App\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Models\PaymentGateway;

class Currency extends Model {

protected $table ="Currency";
protected $fillable = ['currency_code','gateway_id'];

	public function gateway(){

		return $this->belongsTo(PaymentGateway::class, 'gateway_id', 'id');

	}


}

?>