<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerAccueil.php');

class ControllerLogin {

	private $_view;
	private $_userManager;
	private $_user;

	public function __construct($url) {
		if (isset($url) && count($url) > 1) {
			throw new Exception('Page Introuvable');
		}
		else if (!isset($_POST['username']) && !isset($_POST['password'])) {
			$this->generateLoginView();
		}
		else {
			$this->authUser();
		}
	}

	private function generateLoginView() {
		$this->_view = new View('Login');
		if (!isset($_POST['username']) && !isset($_POST['password']))
			$this->_view->generate(array());
		else if (empty($this->_user))
			$this->_view->generate(array('error' => 'username'));
		else
			$this->_view->generate(array('error' => 'password'));
		$_POST = array();
	}

	private function authUser() {
		$this->_userManager = new UserManager;
		$this->_user = $this->_userManager->getUserByName(htmlspecialchars($_POST['username']));
		if (!empty($this->_user) && $this->_user->login(htmlspecialchars($_POST['password']))) {
			header('Location: index.php');
		}
		else {
			$this->generateLoginView();
		}
	}
}

?>
