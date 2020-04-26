<?php

namespace Camagru\Controller;

use \Camagru\View\View;
use \Exception;

class Router {
	private $_controller;
	private $_view;

	public function route() {
		try {
			$url = '';
			if (isset($_GET['url'])) {
				$url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
				$controller = ucfirst(strtolower($url[0]));
				$controllerClass = 'Controller' . $controller;
				$controllerFile = __DIR__ . '/' . $controllerClass . '.php';
				
				if (file_exists($controllerFile)) {
					$controllerNamespace = '\Camagru\Controller\\';
					$controllerFQCN = $controllerNamespace . $controllerClass;
					$this->_controller = new $controllerFQCN($url);
				} else {
					throw new Exception('Page Introuvable');
				}
			} else {
				require_once('ControllerAccueil.php');
				$this->_controller = new ControllerAccueil($url);
			}
		} catch(Exception $e) {
			$errorMsg = $e->getMessage();
			$errorMsg = $controllerFile;
			$this->_view = new View('Error');
			$this->_view->generate(array('errorMsg' => $errorMsg));
		}
	}
}

?>
