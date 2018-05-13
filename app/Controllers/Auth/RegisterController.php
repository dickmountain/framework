<?php

namespace App\Controllers\Auth;

use App\Auth\Hashing\Hasher;
use App\Controllers\Controller;
use App\Models\User;
use App\Views\View;
use Doctrine\ORM\EntityManager;
use League\Route\RouteCollection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RegisterController extends Controller
{
	protected $view;
	protected $hash;
	protected $route;
	protected $db;

	public function __construct(View $view, Hasher $hash, RouteCollection $route, EntityManager $db)
	{
		$this->view = $view;
		$this->hash = $hash;
		$this->route = $route;
		$this->db = $db;
	}

	public function index(RequestInterface $request, ResponseInterface $response)
	{
		return $this->view->render($response, 'auth/register.twig');
	}

	public function register(RequestInterface $request, ResponseInterface $response)
	{
		$data = $this->validateRegistration($request);

		$user = $this->createUser($data);

		return redirect($this->route->getNamedRoute('home')->getPath());
	}

	protected function createUser($data)
	{
		$user = new User();

		$user->fill([
			'name' => $data['name'],
			'email' => $data['email'],
			'password'=> $this->hash->create($data['password']),
		]);

		$this->db->persist($user);
		$this->db->flush();

		return $user;
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