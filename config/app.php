<?php

return [
	'name' => env('APP_NAME'),
	'debug' => env('APP_DEBUG', false),

	'providers' => [
		'App\Providers\ViewServiceProvider',
		'App\Providers\AppServiceProvider',
		'App\Providers\DoctrineServiceProvider',
		'App\Providers\EloquentServiceProvider',
		'App\Providers\SessionServiceProvider',
		'App\Providers\HashServiceProvider',
		'App\Providers\AuthServiceProvider',
		'App\Providers\CsrfServiceProvider',
		'App\Providers\ValidationServiceProvider',
		'App\Providers\CookiesServiceProvider',
		'App\Providers\ViewShareServiceProvider',
		'App\Providers\PaginationServiceProvider',
	],

	'middleware' => [
		'App\Middleware\ShareValidationErrors',
		'App\Middleware\ClearValidationErrors',
		'App\Middleware\Authenticate',
		'App\Middleware\AuthenticateFromCookies',
		'App\Middleware\CsrfGuard',
	]
];