<?php

namespace App\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Models\Currency;

class PaymentGateway extends Model {

protected $table ="PaymentGateways";

	public function currencies(){
	
	  return $this->hasMany(Currency::class , 'gateway_id');

	}

	public static function getId($name){
		return self::select('id')->where('gateway_name',$name)->first();
	}
}

?>