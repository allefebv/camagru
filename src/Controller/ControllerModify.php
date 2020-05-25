<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\UserRepository;
use Camagru\Service\ViewGenerator;
use Camagru\Service\UserRegisterer;
use \Exception;

class ControllerModify {

	private $viewGenerator;
	private $json;
	private $userRepository;
	private $userRegisterer;
	private $user;

	public function __construct($url) {
		if (isset($url) && count($url) > 1) {
			throw new Exception('Page Introuvable');
		}
		else if (!isset($_SESSION['logged'])) {
			header('Location: index.php');
		}
		else if ($this->json = file_get_contents('php://input')) {
			$this->userRegisterer = new UserRegisterer();
			$this->actionDispatch();
		}
		else {
			$this->generateModifyView();
		}
	}

	private function actionDispatch() {
		$this->json = json_decode($this->json, TRUE);
		$this->userRepository = new UserRepository;
		$this->user = ($this->userRepository->getUserById($_SESSION['logged']))[0];
		if (isset($this->json['email'])) {
			$this->email();
		}
		else if (isset($this->json['password'])) {
			$this->password();
		}
		else if (isset($this->json['username'])) {
			$this->username();
		}
		else if (isset($this->json['delete'])) {
			$this->delete();
		}
	}

	private function username() {
		$response = $this->userRegisterer->updateUserUsername(
			$this->user,
			$this->json['password'],
			$this->json['new_username']
		);
		echo \json_encode($response);
	}

	private function email() {
		$response = $this->userRegisterer->updateUserEmail(
			$this->user,
			$this->json['password'],
			$this->json['new_email']
		);
		echo \json_encode($response);
	}

	private function password() {
		$response = $this->userRegisterer->updateUserPassword(
			$this->user,
			$this->json['current_password'],
			[$this->json['new_password1'], $this->json['new_password2']]
		);
		echo \json_encode($response);
	}

	private function delete() {
		if (!$this->user->verifyPassword($this->json['password'])) {
			echo json_encode(array('delete' => 1, 'incorrect_pwd' => 1));
		}
		else if (!$this->userRepository->delete($this->user)) {
			echo json_encode(array('delete' => 1, 'db_error' => 1));
		}
		else {
			echo json_encode(array('delete' => 1, 'success' => 1));
			$this->user->logout();
		}
	}

	private function generateModifyView() {
		$this->viewGenerator = new ViewGenerator('Modify');
		$this->viewGenerator->generate(array());
	}
}

?>
