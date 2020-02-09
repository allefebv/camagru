<?php

namespace Camagru;

class Autoloader {

	static private $dirRoot = __DIR__.DIRECTORY_SEPARATOR;

	static function register() {
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}

	static function autoload($class) {
		$class = str_replace('Camagru\\', '', $class);
		$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
		require self::$dirRoot . $class . '.php';
	}

}