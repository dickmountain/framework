<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{
	public function index(RequestInterface $request, ResponseInterface $response)
	{
		$response->getBody()->write(123);

		return $response;
	}
}