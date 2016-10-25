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

Update composer's autoload classes.
<code> composer dumpautoload </code>

Now we will create the tables in the database.
<code> php artisan migrate </code>

Fill the database with some records needed for the application.

<code> php artisan db:seed </code>

