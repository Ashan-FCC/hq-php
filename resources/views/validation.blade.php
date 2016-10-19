@extends('layout')

@section('title')
Test Form Validation
@stop

@section('header')
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		input[type="number"]::-webkit-outer-spin-button,
		input[type="number"]::-webkit-inner-spin-button {
						    	-webkit-appearance: none;
						    	margin: 0;
								}
		input[type="number"] {
							    -moz-appearance: textfield;
							}
	</style>
@stop

@section('content')
<div class="container">
	<form id="form" class="form-horizontal" method="get"  action="#" target="_top" data-parsley-validate>
	<h4>Credit Card Information</h4>
		<div class="form-group text-left">
			<label for="cardType" class="col-xs-2 control-label">Card Type: </label>
			<div class="col-xs-10">        		
	        	<label class="radio-inline">
	            <input type="radio" value="visa" name="creditCardType" required checked="checked"> Visa
	        	</label>
	        	<label class="radio-inline">
	            <input type="radio" value="mastercard" name="creditCardType" required> Mastercard
	        	</label>
	        	<label class="radio-inline">
	            <input type="radio" value="amex" name="creditCardType" required> American Express
	        	</label>
	        	<label class="radio-inline">
	            <input type="radio" value="discover" name="creditCardType" required> Discover
	        	</label class="radio-inline">
	        </div>
    	</div>
		<div class="form-group text-left">
			<label for="nameOnCard" class="col-xs-2 control-label">Name on Card: </label>
			<div class="col-xs-4"><input type="text" class="form-control" name="nameOnCard" placeholder="Name on Card" required></div>
    	</div>
    	<div class="form-group text-left">
    		<label for="creditCardNumber" class="col-xs-2 control-label">Credit Card Number: </label>
    		<div class="col-xs-4"><input type="text" name="cardNumber" step="1" class="form-control ccnum" placeholder="xxxxxxxxxxxxxxxx" required></div>
		</div>
		<div class="form-group text-left">
    		<label for="cardExpireMonth" class="col-xs-2 control-label">Card Expire Month: </label>
    		<div class="col-xs-2"><input type="number" min="01" max="12" data-parsley-length="[2, 2]" name="cardExpireMonth" class="form-control" placeholder="MM" required></div>
    		<label for="cardExpireYear" class="col-xs-2 control-label">Card Expire Year: </label>
    		<div class="col-xs-2"><input type="number" min="{{ date('Y') }}" data-parsley-length="[4, 4]" name="cardExpireYear" class="form-control" placeholder="YYYY" required></div>
		</div>
		<div class="form-group text-left">
    		<label for="creditCardCVV" class="col-xs-2 control-label">CVV: </label>
    		<div class="col-xs-2"><input type="password" name="creditCardCVV" data-parsley-length="[3, 4]" class="form-control" placeholder="CVV" required autocomplete="off"></div>
		</div>
		<div class="form-group text-left">
	    <div class="col-xs-offset-2 col-xs-10">
	      <button class="btn btn-default" id="submitPayment">Pay</button>
	    </div>
	    </div>
	</form>
</div>

@stop
	
@section('footer')
<script src="js/parsley.min.js"></script>
<script>
	
</script>
@stop