<?php

return [
	'doctrine_mysql' => [
		'driver' => env('DB_DRIVER', 'pdo_mysql'),
		'host' => env('DB_HOST', 'pdo_mysql'),
		'dbname' => env('DB_DATABASE', 'database'),
		'user' => env('DB_USERNAME'),
		'password' => env('DB_PASSWORD'),
	],
	'eloquent_mysql' => [
		'driver' => 'mysql',
		'host' => env('DB_HOST', 'pdo_mysql'),
		'database' => env('DB_DATABASE', 'database'),
		'username' => env('DB_USERNAME'),
		'password' => env('DB_PASSWORD'),
		'port' => env('DB_PORT'),
		'charset' => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix' => '',
	]
];