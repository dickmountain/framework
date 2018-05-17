<?php

namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Controllers\Controller;
use App\Session\Flash;
use App\Views\View;
use League\Route\RouteCollection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LoginController extends Controller
{
	protected $view;
	protected $auth;
	protected $route;
	protected $flash;

	public function __construct(View $view, Auth $auth, RouteCollection $route, Flash $flash)
	{
		$this->view = $view;
		$this->auth = $auth;
		$this->route = $route;
		$this->flash = $flash;
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

		$attempt = $this->auth->attempt($data['email'], $data['password'], isset($data['remember']));

		if (!$attempt) {
			$this->flash->now('error', 'Auth error');
			return redirect($request->getUri()->getPath());
		}

		return redirect($this->route->getNamedRoute('home')->getPath());
	}
}