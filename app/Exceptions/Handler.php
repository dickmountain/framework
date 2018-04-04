<?php

namespace App\Exceptions;

use App\Session\SessionInterface;
use Exception;
use ReflectionClass;
use Zend\Diactoros\Response\RedirectResponse;

class Handler
{
	protected $exception;
	protected $session;

	public function __construct(Exception $exception, SessionInterface $session)
	{
		$this->exception = $exception;
		$this->session = $session;
	}

	public function respond()
	{
		$class = (new ReflectionClass($this->exception))->getShortName();

		if (method_exists($this, $method = "handle{$class}")) {
			return $this->{$method}($this->exception);
		}
		
		return $this->unhandledException($this->exception);
	}

	protected function handleValidationException(ValidationException $e)
	{
		$this->session->set([
			'errors' => $e->getErrors(),
			'old' => $e->getOldInput()
		]);

		return redirect('/auth/login');
	}

	protected function unhandledException(Exception $e)
	{
		throw $e;
	}
}