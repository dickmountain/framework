<?php

$route->get('/', function ($request, $response) {
	$response->getBody()->write('123');

	return $response;
});