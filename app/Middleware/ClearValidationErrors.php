<?php

namespace App\Middleware;


use App\Session\SessionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClearValidationErrors
{
	protected $session;

	public function __construct(SessionInterface $session)
	{
		$this->session = $session;
	}

	public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
	{
		$next = $next($request, $response);

		$this->session->clear('errors', 'old');

		return $next;
	}
}