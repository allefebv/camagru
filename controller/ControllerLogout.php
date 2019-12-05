<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');

class ControllerLogout {

	private $_view;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		$this->logoutUser();
	}

	private function logoutUser() {
		unset($_SESSION['logged']);
		header('Location: index.php');
	}
}

?>
