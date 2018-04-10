<?php

use App\Exceptions\Handler;
use App\Session\SessionInterface;
use Dotenv\{Dotenv, Exception\InvalidPathException};
use League\Route\RouteCollection;

session_start();

require_once __DIR__.'/../vendor/autoload.php';

try {
	$dotenv = (new Dotenv(base_path()))->load();
} catch (InvalidPathException $e) {

}

require_once base_path('bootstrap/container.php');

$route = $container->get(RouteCollection::class);

require_once base_path('bootstrap/middleware.php');
require_once base_path('routes/web.php');

try {
	$response = $route->dispatch(
		$container->get('request'), $container->get('response')
	);
} catch (Exception $e) {
	$handler = new Handler($e, $container->get(SessionInterface::class));
	$response = $handler->respond();
}

