<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return view('index');
});

$app->get('/form' , function() use($app){
	return view('validation');
});

$app->post('/v1/processcreditcard' , 'PaymentController@processCreditCard');

$app->get('/v1/FirstCall' , 'PaymentController@firstcall');


$app->get('/v1/gateways' , 'PaymentGatewayController@index');
$app->get('/v1/currencies' , 'CurrencyController@index');
$app->get('/v1/cardtypes' , 'CreditCardController@index');

//AQvpue7fNEG5l7nzXL9ZzqN0FhExb6hZ9atuGh3ITQc29FjxSvv1VacTL4Cnl7ncsd6QCds6m3droPgg

// secret - EN_1OMKrE-LGh8dEf5dRAYG-s2EgjqDOPua_Cm_JOAq_fcVljwoM0ywwDMNtpOWQsw0kuh5vDoeLQMwJ