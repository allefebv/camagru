<?php

session_start();
require_once('controller/Router.php');

$router = new Router();
$router->route();

?>
