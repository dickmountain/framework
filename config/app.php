<?php

return [
	'name' => env('APP_NAME'),
	'debug' => env('APP_DEBUG', false),

	'providers' => [
		'App\Providers\ViewServiceProvider',
		'App\Providers\AppServiceProvider',
		'App\Providers\DatabaseServiceProvider',
		'App\Providers\SessionServiceProvider',
		'App\Providers\ViewShareServiceProvider',
		'App\Providers\HashServiceProvider',
		'App\Providers\AuthServiceProvider',
	],

	'middleware' => [
		'App\Middleware\ShareValidationErrors',
		'App\Middleware\ClearValidationErrors',
		'App\Middleware\Authenticate',
	]
];