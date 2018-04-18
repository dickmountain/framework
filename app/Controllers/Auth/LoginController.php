<?php

namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Controllers\Controller;
use App\Views\View;
use League\Route\RouteCollection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LoginController extends Controller
{
	protected $view;
	protected $auth;
	protected $route;

	public function __construct(View $view, Auth $auth, RouteCollection $route)
	{
		$this->view = $view;
		$this->auth = $auth;
		$this->route = $route;
	}

	public function index(RequestInterface $request, ResponseInterface $response)
	{
		return $this->view->render($response, 'auth/login.twig');
	}

	public function login(RequestInterface $request, ResponseInterface $response)
	{
		$data = $this->validate($request,[
			'email' => ['required', 'email'],
			'password' => ['required'],
		]);

		$attempt = $this->auth->attempt($data['email'], $data['password']);

		if (!$attempt) {
			//
		}

		return redirect($this->route->getNamedRoute('home')->getPath());
	}
}