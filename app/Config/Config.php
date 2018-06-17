<?php

namespace App\Config;


use App\Config\Loaders\Loader;

class Config
{
	protected $config = [];
	protected $cache = [];

	public function load(array $loaders)
	{
		$this->config = array_reduce($loaders, function ($config, Loader $loader) {
			return $config[] = $loader->parse();
		});

		return $this;
	}

	public function get($key, $default = null)
	{
		if ($this->exists($this->cache, $key)) {
			return $this->cache[$key];
		}

		return $this->addToCache($key, $this->extractFromConfig($key) ?? $default);
	}

	protected function extractFromConfig($key)
	{
		$filtered = array_reduce(explode('.', $key), function ($filtered, $key_part) {
			if($this->exists($filtered, $key_part)) {
				return $filtered[$key_part];
			}
			return null;
		}, $this->config);

		return $filtered;
	}

	protected function exists(array $config, $key)
	{
		return array_key_exists($key, $config);
	}

	protected function addToCache($key, $value)
	{
		$this->cache[$key] = $value;

		return $value;
	}
}