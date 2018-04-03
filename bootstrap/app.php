<?php

use App\Exceptions\Handler;

session_start();

require_once __DIR__.'/../vendor/autoload.php';

try {
	$dotenv = (new Dotenv\Dotenv(base_path()))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {

}

require_once base_path('bootstrap/container.php');

$route = $container->get(League\Route\RouteCollection::class);

require_once base_path('routes/web.php');

try {
	$response = $route->dispatch(
		$container->get('request'), $container->get('response')
	);
} catch (Exception $e) {
	$handler = new Handler($e);
	$response = $handler->respond();
}

