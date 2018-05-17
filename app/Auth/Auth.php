<?php

namespace App\Auth;


use App\Auth\Hashing\Hasher;
use App\Cookies\Cookies;
use App\Models\User;
use App\Session\SessionInterface;
use Doctrine\ORM\EntityManager;
use Exception;

class Auth
{
	protected $db;
	protected $hash;
	protected $session;
	protected $user;
	protected $recaller;
	protected $cookies;

	public function __construct(
		EntityManager $db,
		Hasher $hash,
		SessionInterface $session,
		Recaller $recaller,
		Cookies $cookies
	)
	{
		$this->db = $db;
		$this->hash = $hash;
		$this->session = $session;
		$this->recaller = $recaller;
		$this->cookies = $cookies;
	}
	
	public function attempt($username, $password, $remember = false)
	{
		$user = $this->getByUsername($username);

		if (!$user or !$this->hasValidCredentials($user, $password)) {
			return false;
		}

		if ($this->needsRehash($user)) {
			$this->rehashPassword($user, $password);
		}

		$this->setUserSession($user);

		if ($remember) {
			$this->setRememberToken($user);
		}

		return true;
	}

	public function logout()
	{
		$this->session->clear('id');
	}
	
	public function user()
	{
		return $this->user;
	}

	public function check()
	{
		return $this->hasUserInSession();
	}

	public function hasUserInSession()
	{
		return $this->session->exists('id');
	}

	public function setUserFromSession()
	{
		$user = $this->getById($this->session->get('id'));

		if (!$user) {
			throw new Exception();
		}

		$this->user = $user;
	}

	protected function needsRehash($user)
	{
		return $this->hash->needsRehash($user->password);
	}

	protected function rehashPassword($user, $password)
	{
		$this->db->getRepository(User::class)->find($user->id)->update([
			'password' => $this->hash->create($password)
		]);

		$this->db->flush();
	}
	
	protected function setUserSession($user)
	{
		$this->session->set('id', $user->id);
	}

	protected function hasValidCredentials($user, $password)
	{
		return $this->hash->check($password, $user->password);
	}

	protected function getById($id)
	{
		return $this->db->getRepository(User::class)->find($id);
	}

	protected function getByUsername($username)
	{
		return $this->db->getRepository(User::class)->findOneBy([
			'email' => $username
		]);
	}

	protected function setRememberToken($user)
	{
		list($identifier, $token) = $this->recaller->generate();

		$this->cookies->set('remember', $this->recaller->generateValueForCookie($identifier, $token));

		$this->db->getRepository(User::class)->find($user->id)->update([
			'remember_identifier' => $identifier,
			'remember_token' => $this->recaller->generateTokenHashForDatabase($token)
		]);

		$this->db->flush();
	}
}