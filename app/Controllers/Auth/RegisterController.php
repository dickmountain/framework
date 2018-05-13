<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use App\Views\View;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RegisterController extends Controller
{
	protected $view;

	public function __construct(View $view)
	{
		$this->view = $view;
	}

	public function index(RequestInterface $request, ResponseInterface $response)
	{
		return $this->view->render($response, 'auth/register.twig');
	}

	public function register(RequestInterface $request, ResponseInterface $response)
	{
		$data = $this->validateRegistration($request);


	}

	protected function validateRegistration($request)
	{
		return $this->validate($request, [
			'email' => ['required', 'email', ['exists', User::class]],
			'name' => ['required'],
			'password' => ['required'],
			'password_confirmation' => ['required', ['equals', 'password']],
		]);
	}
}