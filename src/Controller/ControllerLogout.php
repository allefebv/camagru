<?php

namespace Camagru\Controller;

use \Exception;

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
