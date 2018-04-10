<?php

namespace App\Middleware;

use App\Session\SessionInterface;
use App\Views\View;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ShareValidationErrors
{
	protected $view;
	protected $session;

	public function __construct(View $view, SessionInterface $session)
	{
		$this->view = $view;
		$this->session = $session;
	}

	public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
	{
		$this->view->share([
			'errors' => $this->session->get('errors', []),
			'old' => $this->session->get('old', [])
		]);

		return $next($request, $response);
	}
}