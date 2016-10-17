<?php

namespace App\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class Restriction extends Model {

protected $table ="Restrictions";
protected $fillable = ['card_type','currency_code'];

	public static function restricted($cardtype, $currency){
		$restrictions = self::select('currency_code')->where('card_type',$cardtype)->get();
		if(count($restrictions) > 0){
			foreach($restrictions as $rest){
				if($rest->currency_code === $currency)
					return true;
			}
		}
		return false;

	}
}

?>