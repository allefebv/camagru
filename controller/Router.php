<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class Router {
	private $_controller;
	private $_view;

	public function route() {
		try {
			$url = '';
			if (isset($_GET['url']))
			{
				$url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
				$controller = ucfirst(strtolower($url[0]));
				$controllerClass = 'Controller' . $controller;
				$controllerFile = 'controller/' . $controllerClass . '.php';
				if (file_exists($controllerFile))
				{
					require_once($controllerFile);
					$this->$_controller = new $controllerClass($url);
				}
				else
					throw new Exception('Page Introuvable');
			}
			else
			{
				require_once('ControllerAccueil.php');
				$this->$_controller = new ControllerAccueil($url);
			}
		}
		catch(Exception $e) {
			$errorMsg = $e->getMessage();
			require_once('view/viewError.php');
		}
	}
}

?>