<?php

namespace App\Middleware;

use App\Auth\Auth;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Authenticated
{
	protected $auth;

	public function __construct(Auth $auth)
	{
		$this->auth = $auth;
	}

	public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
	{
		if (!$this->auth->check()) {
			$response = redirect('/');
		}

		return $next($request, $response);
	}
}