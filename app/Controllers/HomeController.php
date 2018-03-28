<?php

namespace App\Controllers;

use App\Models\User;
use App\Views\View;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{
	protected $view;
	protected $db;

	public function __construct(View $view, EntityManager $db)
	{
		$this->view = $view;
		$this->db = $db;
	}

	public function index(RequestInterface $request, ResponseInterface $response)
	{
		$user = $this->db->getRepository(User::class)->find(1);

		return $this->view->render($response, 'home.twig', [
			'user' => $user
		]);
	}
}