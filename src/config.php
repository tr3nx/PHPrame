<?php

return [
	'routes' => [
		'/name/(name:[a-zA-Z0-9]+)' => '\App\Controllers\Home::myname',
		'/(name:[^0-9][a-zA-Z0-9]+)' => '\App\Controllers\Home::name',
		'/(id:[0-9]+)' => '\App\Controllers\Home::select',
		'/form' => '\App\Controllers\Home::form',
		'/submit' => '\App\Controllers\Home::submit',
		'/thankyou' => '\App\Controllers\Home::thankyou',
		'/home' => '\App\Controllers\Home::index',
		'/' => '\App\Controllers\Home::index',
		'/404' => '\App\Controllers\Home::fourohfour',
	],
	'database' => [
		'dsn' => 'host=localhost port=5432 dbname=ih user=postgres password=sergtsop',
		'persistent' => true
	]
];
