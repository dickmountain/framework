<?php

return [
	'debug' => env('APP_DEBUG', false),

	'providers' => [
		'App\Providers\ViewServiceProvider',
		'App\Providers\AppServiceProvider',
		'App\Providers\DatabaseServiceProvider',
		'App\Providers\SessionServiceProvider',
	],

	'middleware' => [
		'App\Middleware\ShareValidationErrors',
		'App\Middleware\ClearValidationErrors',
	]
];