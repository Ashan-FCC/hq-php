<?php

namespace App\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Models\PaymentGateway;
use PDOException;

class CreditCardResponse extends Model {

protected $table ="CreditCardResponse";
protected $guarded = ['id'];

}

?>