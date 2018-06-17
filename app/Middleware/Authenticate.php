<?php

namespace App\Middleware;


use App\Auth\Auth;
use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Authenticate
{
	protected $auth;

	public function __construct(Auth $auth)
	{
		$this->auth = $auth;
	}

	public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
	{
		if ($this->auth->hasUserInSession()) {
			try {
				$this->auth->setUserFromSession();
			} catch (Exception $e) {
				$this->auth->logout();
			}
		}

		return $next($request, $response);
	}
}