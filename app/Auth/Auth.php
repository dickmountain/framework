<?php

namespace App\Auth;


use App\Auth\Hashing\Hasher;
use App\Models\User;
use App\Session\SessionInterface;
use Doctrine\ORM\EntityManager;

class Auth
{
	protected $db;
	protected $hash;
	protected $session;

	public function __construct(EntityManager $db, Hasher $hash, SessionInterface $session)
	{
		$this->db = $db;
		$this->hash = $hash;
		$this->session = $session;
	}
	
	public function attempt($username, $password)
	{
		$user = $this->getByUsername($username);

		if (!$user or !$this->hasValidCredentials($user, $password)) {
			return false;
		}

		$this->setUserSession($user);

		return true;
	}

	protected function setUserSession($user)
	{
		$this->session->set('id', $user->id);
	}

	protected function hasValidCredentials($user, $password)
	{
		return $this->hash->check($password, $user->password);
	}

	protected function getByUsername($username)
	{
		return $this->db->getRepository(User::class)->findOneBy([
			'email' => $username
		]);
	}
}