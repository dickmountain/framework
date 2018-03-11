<?php

session_start();

require_once __DIR__.'/../vendor/autoload.php';

try {
	$dotenv = (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {

}
