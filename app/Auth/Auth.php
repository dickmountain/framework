<?php

namespace App\Auth;

use App\Auth\Hashing\Hasher;
use App\Auth\Providers\UserInterface;
use App\Cookies\Cookies;
use App\Session\SessionInterface;
use Exception;

class Auth
{
	protected $hash;
	protected $session;
	protected $user;
	protected $recaller;
	protected $cookies;
	protected $userProvider;

	public function __construct(
		Hasher $hash,
		SessionInterface $session,
		Recaller $recaller,
		Cookies $cookies,
		UserInterface $userProvider
	)
	{
		$this->hash = $hash;
		$this->session = $session;
		$this->recaller = $recaller;
		$this->cookies = $cookies;
		$this->userProvider = $userProvider;
	}
	
	public function attempt($username, $password, $remember = false)
	{
		$user = $this->userProvider->getByUsername($username);

		if (!$user or !$this->hasValidCredentials($user, $password)) {
			return false;
		}

		if ($this->needsRehash($user)) {
			$this->userProvider->rehashPassword($user->id, $this->hash->create($password));
		}

		$this->setUserSession($user);

		if ($remember) {
			$this->setRememberToken($user);
		}

		return true;
	}

	public function logout() // test
	{
		$this->userProvider->clearRememberIdentifier($this->user->id);

		$this->cookies->clear('remember');
		$this->session->clear('id');
	}
	
	public function user()
	{
		return $this->user;
	}

	public function check()
	{
		return $this->hasUserInSession(); // test
	}

	public function hasUserInSession()
	{
		return $this->session->exists('id');
	}

	public function setUserFromSession()
	{
		$user = $this->userProvider->getById($this->session->get('id'));

		if (!$user) {
			throw new Exception();
		}

		$this->user = $user;
	}

	public function hasRecaller()
	{
		return $this->cookies->exists('remember');
	}

	public function setUserFromCookie()
	{
		list($identifier, $token) = $this->recaller->splitCookieValue($this->cookies->get('remember'));

		if (!($user = $this->userProvider->getByRememberIdentifier($identifier))) {
			$this->cookies->clear('remember');
			return;
		}

		if (!$this->recaller->validateToken($token, $user->remember_token)) {
			$this->userProvider->clearRememberIdentifier($user->id);

			$this->cookies->clear('remember');

			throw new Exception();
		}

		$this->setUserFromSession($user);
	}

	protected function needsRehash($user)
	{
		return $this->hash->needsRehash($user->password);
	}
	
	protected function setUserSession($user)
	{
		$this->session->set('id', $user->id);
	}

	protected function hasValidCredentials($user, $password)
	{
		return $this->hash->check($password, $user->password);
	}

	protected function setRememberToken($user)
	{
		list($identifier, $token) = $this->recaller->generate();

		$this->cookies->set('remember', $this->recaller->generateValueForCookie($identifier, $token));

		$this->userProvider->setUserRememberToken($user->id, $identifier, $this->recaller->generateTokenHashForDatabase($token));
	}
}