<?php

namespace App\Views;

use Psr\Http\Message\ResponseInterface;
use Twig_Environment;

class View
{
	protected $twig;

	public function __construct(Twig_Environment $twig)
	{
		$this->twig = $twig;
	}

	public function make($view, array $data = [])
	{
		return $this->twig->render($view, $data);
	}

	public function render(ResponseInterface $response, $view, $data = [])
	{
		$response->getBody()->write(
			$this->make($view, $data)
		);

		return $response;
	}

	public function share(array $data)
	{
		foreach ($data as $key => $value) {
			$this->twig->addGlobal($key, $value);
		}
	}
}