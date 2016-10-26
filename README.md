# hq-php
Repo to test integrating with paypal and braintree.

<h2>Prerequisites</h2>

<ul>PHP 5.3 or above</ul>
<ul>curl, json & openssl extensions must be enabled</ul>


Clone the project and in the project root folder, run 

<code>composer install </code>

Create a database called PaymentIntegration using mysql.
Edit .env file in the root directory. 
Set the database name, user and password.

In the document root run the following commands.

1. Update composer's autoload classes. <br>
<code> composer dumpautoload </code>

2. Now we will create the tables in the database. <br>
<code> php artisan migrate </code>

3. Fill the database with some records needed for the application. <br>
<code> php artisan db:seed </code>

Create a php server with the public folder of the application as the document root. <br>
<code> php -S localhost:8080 -t public </code> 

If using a different port number,  edit the field API_URL in the .env file.


Open a browser and go to localhost:8080 and the payment form will be available.

Here are some valid credit card numbers for testing in Braintree gateway. Braintree gateway will be automatically chosen when using the currencies HKD, SGD and THB.

<table>
<thead>
<tr>
<th>Test Value</th>
<th>Card Type</th>
</tr>
</thead>
<tbody>
<tr>
<td><code >378282246310005</code></td>
<td>American Express</td>
</tr>
<tr>
<td><code >371449635398431</code></td>
<td>American Express</td>
</tr>
<tr>
<td><code >6011111111111117</code></td>
<td>Discover</td>
</tr>
<tr>
<td><code >5555555555554444</code></td>
<td>Mastercard</td>
</tr>
<tr>
<td><code >2223000048400011</code></td>
<td>Mastercard</td>
</tr>
<tr>
<td><code >4111111111111111</code></td>
<td>Visa</td>
</tr>
<tr>
<td><code >4005519200000004</code></td>
<td>Visa</td>
</tr>
<tr>
<td><code >4009348888881881</code></td>
<td>Visa  </td>
</tr>
<tr>
<td><code >4012000033330026</code></td>
<td>Visa</td>
</tr>
<tr>
<td><code >4012000077777777</code></td>
<td>Visa</td>
</tr>
<tr>
<td><code >4012888888881881</code></td>
<td>Visa</td>
</tr>
<tr>
<td><code >4217651111111119</code></td>
<td>Visa</td>
</tr>
<tr>
<td><code >4500600000000061</code></td>
<td>Visa</td>
</tr>
</tbody>
</table>

<b> Valid Card Numbers for PayPal </b>
<table>
<thead>
<tr>
<th>Test Value</th>
<th>Card Type</th>
</tr>
</thead>
<tbody>
<tr>
<td><code >5421135181362637</code></td>
<td>Mastercard</td>
</tr>
<tr>
<td><code >376374933304342</code></td>
<td>American Express</td>
</tr>
<tr>
<td><code >4032032531467923</code></td>
<td>Visa</td>
</tr>
</tbody>
</table>

