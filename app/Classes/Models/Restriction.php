<?php

namespace App\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use PDOException;
use Log;


class Restriction extends Model {

protected $table ="Restrictions";
protected $fillable = ['card_type','currency_code'];

	public static function restricted($cardtype, $currency){
		$restricted = false;
		try{
			$restrictions = self::select('currency_code')->where('card_type',$cardtype)->get();
			Log::info('Restricted Card for currencies',['currecies'=>$restrictions]);
			if(count($restrictions) > 0){
				
				$restricted = true;
				foreach($restrictions as $rest){
					if($rest->currency_code === $currency){
						$restricted = false;
						break;
					}
				}
			}
		}catch(PDOException $ex){
			//echo $ex->getMessage();
			Log::critical('Database call failed. Check ASAP.',['error'=>$ex->getCode() . $ex->getMessage()]);
			$restricted = true;

		}
		
		return $restricted;

	}
}

?>