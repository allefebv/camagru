<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');

class ControllerAccount {

	private $_view;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (isset($_SESSION['logged']))
			throw new Exception('Vous etes deja connecté');
		else if (isset($_POST['login']))
			$this->loginPage();
		else if (isset($_POST['create']))
			$this->createPage();
	}

	private function loginPage() {
		$this->_view = new View('Login');
		$this->_view->generate(array());
	}

	private function createPage() {
		$this->_view = new View('Create');
		$this->_view->generate(array());
	}
}

?>
