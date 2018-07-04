<?php

namespace App\Controllers;

use App\Models\Post;
use App\Views\View;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PostController
{
	protected $view;

	public function __construct(View $view)
	{
		$this->view = $view;
	}

	public function index(RequestInterface $request, ResponseInterface $response)
	{
		$posts = Post::paginate(3);

		return $this->view->render($response, 'posts/index.twig', compact('posts'));
	}
}