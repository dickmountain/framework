<?php

use League\Container\{Container, ReflectionContainer};
use App\Providers\ConfigServiceProvider;

$container = new Container;

$container->delegate(
	new ReflectionContainer
);

$container->addServiceProvider(new ConfigServiceProvider());
foreach ($container->get('config')->get('app.providers') as $provider) {
	$container->addServiceProvider($provider);
}