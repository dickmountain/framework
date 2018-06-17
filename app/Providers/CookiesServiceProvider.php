<?php

namespace App\Providers;

use App\Cookies\Cookies;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CookiesServiceProvider extends AbstractServiceProvider
{
	protected $provides = [
		Cookies::class
	];

	public function register()
	{
		$container = $this->getContainer();

		$container->share(Cookies::class, function () use ($container) {
			return new Cookies();
		});
	}
}