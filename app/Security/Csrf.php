<?php

namespace App\Security;


use App\Session\SessionInterface;

class Csrf
{
	protected $session;
	protected $persistToken = true;

	public function __construct(SessionInterface $session)
	{
		$this->session = $session;
	}

	public function key()
	{
		return '_token';
	}

	public function token()
	{
		if (!$this->tokenNeedsToBeGenerated()) {
			return $this->getTokenFromSession();
		}

		$this->session->set($this->key(), $token = bin2hex(random_bytes(32)));

		return $token;
	}

	protected function tokenNeedsToBeGenerated()
	{
		if (!$this->session->exists($this->key())) {
			return true;
		}

		if ($this->shouldPersistToken()) {
			return false;
		}

		return $this->session->exists($this->key());
	}

	protected function shouldPersistToken()
	{
		return $this->persistToken;
	}

	protected function getTokenFromSession()
	{
		return $this->session->get($this->key());
	}
}