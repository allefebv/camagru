<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerAccueil.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerAccount.php');

class ControllerCreate {

	private $_view;
	private $_userManager;
	private $_user;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (isset($_SESSION['logged']))
			throw new Exception('Vous êtes deja connecteé');
		else
			$this->createUser();
	}

	private function createUser() {
		$this->_user = new User(array('username' => $_POST['username'],
									'password' => $_POST['password'],
									'email' => $_POST['email']));
		$_POST = array();
		$_GET = array();
		if (!($this->_user->isValid()))
		{
			$this->_view = new View('Create');
			$this->_view->generate($this->_user->errors());
			unset($this->_user);
			//handle incorrectness (username ? Password ? email ?) (better to handle in the JS ?)
		}
		else
		{
			$this->_userManager = new UserManager;
			$this->_userManager->add($this->_user);
			new ControllerAccueil(NULL);
		}
	}
}

?>
