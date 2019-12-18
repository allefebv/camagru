<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');

class ControllerModify {

	private $_view;
	private $_json;
	private $_userManager;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if ($this->_json = file_get_contents('php://input'))
			$this->actionDispatch();
		else
			$this->generateModifyView();
	}

	private function password() {
		if (!$this->_user->verifyPassword($this->_json['currentPassword'])) {
			echo json_encode(array('password' => 1, 'errorCurrentPassword' => 1));
		}
		else if ($this->_json['newPassword1'] !== $this->_json['newPassword2']) {
			echo json_encode(array('password' => 1, 'errorNewPassword' => 1));
		}
		else if (!$this->_userManager->update($this->_user, 'password', $this->_json['newPassword1'])){
			echo json_encode(array('password' => 1, 'errorDB' => 1));
		}
		else {
			echo json_encode(array('password' => 1, 'success' => 1));
		}
	}

	private function email() {
		if (!$this->_user->verifyPassword($this->_json['passwordEmail'])) {
			echo json_encode(array('email' => 1, 'errorPassword' => 1));
		}
		else if (!$this->_userManager->update($this->_user, 'email', $this->_json['newEmail'])) {
			echo json_encode(array('email' => 1, 'errorDB' => 1));
		}
		else {
			echo json_encode(array('email' => 1, 'success' => 1));
		}
	}

	private function username() {
		if (!$this->_user->verifyPassword($this->_json['passwordUsername'])) {
			echo json_encode(array('username' => 1, 'errorPassword' => 1));
		}
		else if (!$this->_userManager->update($this->_user, 'username', $this->_json['newUsername'])) {
			echo json_encode(array('username' => 1, 'errorDB' => 1));
		}
		else {
			echo json_encode(array('username' => 1, 'success' => 1));
		}
	}

	private function actionDispatch() {
		$this->_json = json_decode($this->_json, TRUE);
		$this->_userManager = new UserManager;
		$this->_user = ($this->_userManager->getUserById($_SESSION['logged']))[0];
		if (isset($this->_json['email'])) {
			$this->email();
		}
		else if (isset($this->_json['password'])) {
			$this->password();
		}
		else if (isset($this->_json['username'])) {
			$this->username();
		}
	}

	private function generateModifyView() {
		$this->_view = new View('Modify');
		$this->_view->generate(array());
	}
}

?>
