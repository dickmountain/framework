<?php

namespace App\Auth\Providers;


interface UserInterface
{
	public function getByUsername($username);
	public function getById($id);
	public function getByRememberIdentifier($identifier);
	public function clearRememberIdentifier($id);
	public function setUserRememberToken($id, $identifier, $hash);
	public function rehashPassword($id, $hash);
}