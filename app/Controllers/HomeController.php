<?php

namespace App\Controllers;

use App\Auth\Hashing\Hasher;
use App\Views\View;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{
	protected $view;
	protected $hash;

	public function __construct(View $view, Hasher $hash)
	{
		$this->view = $view;
		$this->hash = $hash;
	}

	public function index(RequestInterface $request, ResponseInterface $response)
	{
		return $this->view->render($response, 'home.twig');
	}
}