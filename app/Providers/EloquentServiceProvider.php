<?php

namespace App\Providers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Illuminate\Database\Capsule\Manager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class EloquentServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{

	public function register()
	{

	}

	public function boot()
	{
		$container = $this->getContainer();

		$config = $container->get('config');

		$capsule = new Manager();
		$capsule->addConnection($config->get('db.eloquent_mysql'));

		$capsule->setAsGlobal();
		$capsule->bootEloquent();
	}

	
}