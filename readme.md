# hq-php
Repo to test integrating with paypal

<h2>Prerequisites</h2>

<ul>PHP 5.3 or above</ul>
<ul>curl, json & openssl extensions must be enabled</ul>


Clone the project and in the project root folder, run 

<code>composer install </code>

Edit .env file in the root directory. 
Set the database name, user and password.

In the document root run the following commands.

1. Update composer's autoload classes. <br>
<code> composer dumpautoload </code>

2. Now we will create the tables in the database. <br>
<code> php artisan migrate </code>

3. Fill the database with some records needed for the application. <br>
<code> php artisan db:seed </code>

