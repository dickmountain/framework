<?php

return [
	'mysql' => [
		'driver' => env('DB_DRIVER', 'pdo_mysql'),
		'host' => env('DB_HOST', 'pdo_mysql'),
		'dbname' => env('DB_DATABASE', 'database'),
		'user' => env('DB_USERNAME'),
		'password' => env('DB_PASSWORD'),
	]
];