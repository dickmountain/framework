<?php

namespace App\Middleware;


use App\Exceptions\CsrfTokenException;
use App\Security\Csrf;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CsrfGuard
{
	protected $csrf;

	public function __construct(Csrf $csrf)
	{
		$this->csrf = $csrf;
	}

	public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
	{
		if (!$this->requestRequiresProtection($request)) {
			return $next($request, $response);
		}

		if (!$this->csrf->tokenIsValid($this->getTokenFromRequest($request))) {
			throw new CsrfTokenException();
		}

		return $next($request, $response);
	}

	protected function requestRequiresProtection(RequestInterface $request)
	{
		return in_array($request->getMethod(), ['POST', 'PUT', 'PATCH', 'DELETE']);
	}

	protected function getTokenFromRequest(RequestInterface $request)
	{
		return $request->getParsedBody()[$this->csrf->key()] ?? null;
	}
}