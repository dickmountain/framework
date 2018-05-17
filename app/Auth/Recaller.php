<?php

namespace App\Auth;


class Recaller
{

	public function generate()
	{
		return [$this->generateIdentifier(), $this->generateToken()];
	}

	protected function generateIdentifier()
	{
		return bin2hex(random_bytes(32));
	}

	protected function generateToken()
	{
		return bin2hex(random_bytes(32));
	}

	public function generateValueForCookie($identifier, $token)
	{
		return $identifier.'|'.$token;
	}

	public function generateTokenHashForDatabase($token)
	{
		return hash('sha256', $token);
	}
}