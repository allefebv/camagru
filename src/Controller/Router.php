<?php

namespace Camagru\Controller;

use Camagru\Service\ViewGenerator;
use \Exception;

class Router {

	public function route() {
		try {
			$url = '';
			if (isset($_GET['url'])) {
				$url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
				$controllerFQCN = $this->getControllerFQCN($url);
				$controller = new $controllerFQCN($url);
			} else {
				$controller = new ControllerAccueil($url);
			}
		} catch(Exception $e) {
			$errorMsg = $e->getMessage();
			$errorMsg = $controllerFile;
			$viewGenerator = new ViewGenerator('Error');
			$viewGenerator->generate(array('errorMsg' => $errorMsg));
		}
	}

	private function getControllerFQCN(array $url)
	{
		$controller = ucfirst(strtolower($url[0]));
		$controllerClass = 'Controller' . $controller;
		$controllerFile = __DIR__ . '/' . $controllerClass . '.php';
		
		if (file_exists($controllerFile)) {
			$controllerNamespace = '\Camagru\Controller\\';
			return $controllerNamespace . $controllerClass;
		} else {
			throw new Exception('Page Introuvable');
		}
	}
}

?>
