<?php

namespace Camagru\Controller;

use \Camagru\Model\Repositories\UserRepository;

class ControllerLogin {

	private $_view;
	private $_userManager;
	private $_user;

	public function __construct($url) {
		if (isset($url) && count($url) > 1) {
			throw new \Exception('Page Introuvable');
		}
		else if (isset($_SESSION['logged'])) {
			header('Location: index.php');
		}
		else if ($this->_json = file_get_contents('php://input')) {
			$this->authUser();
		}
		else {
			$this->generateLoginView();
		}
	}
	private function authUser() {
		$this->_json = json_decode($this->_json, TRUE);
		$this->_userManager = new UserRepository;
		$this->_user = ($this->_userManager->getUserByEmail(htmlspecialchars($this->_json['email'])))[0];
		if (!$this->_user) {
			echo json_encode(array('emailError' => 1));
		}
		else if (!$this->_user->login(htmlspecialchars($this->_json['password']))) {
			echo json_encode(array('passwordError' => 1));
		}
		else {
			echo json_encode(array('success' => 1));
		}
	}

	private function generateLoginView() {
		$this->_view = new View('Login');
		$this->_view->generate(array());
	}


}

?>
