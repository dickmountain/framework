<?php

namespace App\Auth\Providers;


use App\Models\User;
use Doctrine\ORM\EntityManager;

class DatabaseProvider implements UserInterface
{

	protected $db;

	public function __construct(EntityManager $db)
	{
		$this->db = $db;
	}

	public function getByUsername($username)
	{
		return $this->db->getRepository(User::class)->findOneBy([
			'email' => $username
		]);
	}

	public function getById($id)
	{
		return $this->db->getRepository(User::class)->find($id);
	}

	public function getByRememberIdentifier($identifier)
	{
		return $this->db->getRepository(User::class)->findOneBy([
			'remember_identifier' => $identifier
		]);
	}

	public function clearRememberIdentifier($id)
	{
		$this->db->getRepository(User::class)->find($id)->update([
			'remember_identifier' => null,
			'remember_token' => null
		]);
		$this->db->flush();
	}

	public function rehashPassword($id, $hash)
	{
		$this->db->getRepository(User::class)->find($id)->update([
			'password' => $hash
		]);

		$this->db->flush();
	}

	public function setUserRememberToken($id, $identifier, $hash)
	{
		$this->db->getRepository(User::class)->find($id)->update([
			'remember_identifier' => $identifier,
			'remember_token' => $hash
		]);

		$this->db->flush();
	}
}