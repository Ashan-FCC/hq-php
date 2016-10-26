@extends('layout')<!DOCTYPE html>

@section('title')
	Test Payment
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
<hr>

<div class="container">
		<div class="error">
			
		</div>
		<div class="success">
			
		</div>
		<form class="form-horizontal" method="post" id="Payment"  action="{{env('API_URL')}}/v1/processcreditcard" target="_top" data-parsley-validate>
		<h4 class = "col-xs-12"> Order</h4>
		<div class="form-group text-left">		
			<label for="amount" class="col-xs-2 control-label">Amount: </label>
			<div class="col-xs-2"><input type="number" min="0" step="0.01" class="form-control" name="amount" id="Amount" required"></div>
			<span class="col-xs-8 text-danger" id="Amount-Error"></span>
		</div>
		<div class="form-group">
			<label for="currency" class="col-xs-2 control-label">Currency: </label>
	        	<div class="col-xs-10">        		
	        	<label class="radio-inline">
	            <input type="radio" value="USD" name="currency" required checked="checked"> USD
	        	</label>
	        	<label class="radio-inline">
	            <input type="radio" value="EUR" name="currency" required> EUR
	        	</label>
	        	<label class="radio-inline">
	            <input type="radio" value="THB" name="currency" required> THB
	        	</label>
	        	<label class="radio-inline">
	            <input type="radio" value="HKD" name="currency" required> HKD
	        	</label class="radio-inline">
	        	<label class="radio-inline">
	            <input type="radio" value="SGD" name="currency" required> SGD
	        	</label class="radio-inline">
	        	<label class="radio-inline">
	            <input type="radio" value="AUD" name="currency" required> AUD
	        	</label>
	        	</div>   
		</div>

		<div class="form-group">
			<label for="customerName" class="col-xs-2 control-label">Customer Full Name: </label>
				<div class="col-xs-6">
					<input type="text" class="form-control" name="customerName" id="FullName" required>
				</div>
			<div class="col-xs-4 text-danger" id="Name-Error"></div>
		</div>

		<hr>

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
    		<div class="col-xs-2"><input type="number" min="01" max="12" name="cardExpireMonth" class="form-control" placeholder="MM" required></div>
    		<label for="cardExpireYear" class="col-xs-2 control-label">Card Expire Year: </label>
    		<div class="col-xs-2"><input type="number" min="{{ date('Y') }}" name="cardExpireYear" class="form-control" placeholder="YYYY" required></div>
		</div>
		<div class="form-group text-left">
    		<label for="creditCardCVV" class="col-xs-2 control-label">CVV: </label>
    		<div class="col-xs-2"><input type="password" name="creditCardCVV" class="form-control" placeholder="CVV" required autocomplete="off"></div>
		</div>

	    </form>
	    		<div class="form-group text-left">
	    <div class="col-xs-offset-2 col-xs-10">
	      <button class="btn btn-default" id="submitPayment">Pay</button>
	    </div>
	    </div>

	    

</div>
@stop

@section('footer')
<script src="js/parsley.min.js"></script>
	<script>
		$(document).ready(function(){

			$("#submitPayment").on('click', function(){

			$(this).text("Processing");
      		$(this).attr("disabled", true);
				
				$.ajax({
					url : "{{env('API_URL')}}/v1/processcreditcard",
					method : 'POST',
					data : $("#Payment").serialize(),
					dataType : 'json',
					error : function(data , status, resp){
						console.log('Error data: ', data);
						console.log('Error status: ', status);
						console.log('Error resp: ', resp);
						var obj = $.parseJSON(data.responseText);
						var err = obj.errors;
						$.each(err , function(index, value){
			      			console.log(value);
			      			appendError(value);
			      		});
			     	var transaction_error = '<div class="alert alert-danger fade in">';
			     		transaction_error+= '<a href="/" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
						transaction_error += 'Transaction Failed. Close this to start a new transaction.</div>';
						$(transaction_error).appendTo(".container > .error");
  				
					},
					success : function(data , status, resp){

						var obj = $.parseJSON(resp.responseText);;
						var successMsg = data['success'];
						var success = '<div class="alert alert-success fade in">';
						 	success += '<a href="/" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
							success += successMsg+'Close this for a new transaction.</div>';
							$(success).appendTo(".container > .success");
						//4111111111111111
					},
					complete : function(){
						//$("#submitPayment").attr("disabled", false);
						$("#submitPayment").text("Pay");
						$("#submitPayment").attr("disabled", true);
					},
					timeout : 60000,
				});

			});

			function enableButton(){

			}

			var appendError = function(value){
			var content = '<div class="alert alert-danger fade in">';
			content += '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+value+'</div>';
			$(content).appendTo(".container > .error");
			}
		});
	</script>
@stop
