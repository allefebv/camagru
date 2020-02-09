<?php

use \Camagru\Autoloader;
use \Camagru\Controller\Router;

session_start();
require_once('Autoloader.php');

Autoloader::register();

$router = new Router();
$router->route();

?>
