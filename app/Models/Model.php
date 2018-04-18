<?php

namespace App\Models;


abstract class Model
{
	public function __get($name)
	{
		if (property_exists($this, $name)) {
			return $this->{$name};
		}

		return null;
	}

	public function __isset($name)
	{
		if (property_exists($this, $name)) {
			return true;
		}

		return false;
	}
}