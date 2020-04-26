<?php

use \Camagru\Autoloader;
use \Camagru\Controller\Router;

session_start();
require_once('src/Autoloader.php');

try {
    Autoloader::register();
} catch (\Exception $e) {
    echo 'fail to autoload : ' . $e->getMessage();
}

$router = new Router();
$router->route();
