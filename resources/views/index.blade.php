<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test Payment</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<hr>
<div class="container">

		<form class="form-horizontal" method="post" id="Payment"  action="https://www.sandbox.paypal.com/cgi-bin/webscr" target="_top">
		<h4 class = "col-xs-12"> Order</h4>
		<div class="form-group text-left">		
			<label for="amount" class="col-xs-2 control-label">Amount: </label>
			<div class="col-xs-2"><input type="text" class="form-control" name="amount" id="Amount" required></div>
			<span class="col-xs-8 text-danger" id="Amount-Error">Amount-Error</span>
		</div>
		<div class="form-group">
			<label for="currency" class="col-xs-2 control-label">Currency: </label>
	        	<div class="col-xs-6">        		
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
			<div class="col-xs-4 text-danger" id="Name-Error">Name-Error</div>
		</div>

		<hr>

		<h4>Credit Card Information</h4>
		<div class="form-group text-left">
			<label for="nameOnCard" class="col-xs-2 control-label">Name on Card: </label>
			<div class="col-xs-2"><input type="text" class="form-control" name="nameOnCard" placeholder="Name on Card" required></div>
    	</div>
    	<div class="form-group text-left">
    		<label for="creditCardNumber" class="col-xs-2 control-label">Credit Card Number: </label>
    		<div class="col-xs-2"><input type="text" name="cardNumber" class="form-control" placeholder="xxxxxxxxxxxxxxxx" required></div>
		</div>
		<div class="form-group text-left">
    		<label for="creditCardExpire" class="col-xs-2 control-label">Card Expire Date: </label>
    		<div class="col-xs-2"><input type="text" name="creditCardExpire" class="form-control" placeholder="MM/YY" required></div>
		</div>
		<div class="form-group text-left">
    		<label for="creditCardCVV" class="col-xs-2 control-label">CVV: </label>
    		<div class="col-xs-2"><input type="password" name="creditCardCVV" class="form-control" placeholder="CVV" required></div>
		</div>
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="BPANM4NFYF62G">
	    <div class="form-group text-left">
	    <div class="col-xs-offset-2 col-xs-10">
	      <button type="submit" name="submit" class="btn btn-default" id="submitPayment">Submit</button>
	    </div>
	    </div>
	    </form>
</div>


	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>
</html>