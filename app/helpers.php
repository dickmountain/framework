<?php

if (!function_exists('base_path')) {
	function base_path($path = '') {
		return __DIR__.'/../'.$path;
	}
}

if (!function_exists('env')) {
	function env($key, $default = null) {
		$value = getenv($key);

		if ($value === false) {
			return $default;
		}

		switch (mb_strtolower($value)) {
			case $value === 'true':
				return true;
			case $value === 'false':
				return false;
			default:
				return $value;
		}
	}
}