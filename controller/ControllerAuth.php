<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerAccueil.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerAccount.php');

class ControllerAuth {

	private $_view;
	private $_userManager;
	private $_user;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (isset($_POST['logout']))
			$this->logoutUser();
		else if (!isset($_POST['username']))
			throw new Exception('Vous n\'avez rien a faire ici');
		else
			$this->authUser();
	}

	private function authUser() {
		$this->_userManager = new UserManager;
		$this->_user = $this->_userManager->getUserByName(htmlspecialchars($_POST['username']));
		if (!empty($this->_user) && $this->_user->login(htmlspecialchars($_POST['password'])))
			new ControllerAccueil(NULL);
		else
		{
			$this->_view = new View('Login');
			if (empty($this->_user))
				$this->_view->generate(array('error' => 'username'));
			else
				$this->_view->generate(array('error' => 'password'));
		}
	}

	private function logoutUser() {
		unset($_SESSION['logged']);
		echo $_SESSION['logged'];
		new ControllerAccueil(NULL);
	}
}

?>
