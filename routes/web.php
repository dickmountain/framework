<?php

use App\Middleware\Authenticated;
use App\Middleware\Guest;

$route->get('/', 'App\Controllers\HomeController::index')->setName('home');

$route->group('', function ($route) {
	$route->get('/dashboard', 'App\Controllers\DashboardController::index')->setName('dashboard');

	$route->post('/auth/logout', 'App\Controllers\Auth\LogoutController::logout')->setName('auth.logout');
})->middleware($container->get(Authenticated::class));

$route->group('', function ($route) {
	$route->get('/auth/login', 'App\Controllers\Auth\LoginController::index')->setName('auth.login');
	$route->post('/auth/login', 'App\Controllers\Auth\LoginController::login');

	$route->get('/auth/register', 'App\Controllers\Auth\RegisterController::index')->setName('auth.register');
	$route->post('/auth/register', 'App\Controllers\Auth\RegisterController::register');
})->middleware($container->get(Guest::class));

