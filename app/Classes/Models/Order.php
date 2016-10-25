<?php

namespace App\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Models\PaymentGateway;

class Order extends Model {

protected $table ="Orders";
protected $guarded = ['id'];


}

?>