<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\UserRepository;
use Camagru\Service\ViewGenerator;
use Camagru\Service\UserRegisterer;
use Camagru\Service\Authenticator;
use \Exception;

class ControllerModify {

	private $viewGenerator;
	private $json;
	private $userRepository;
	private $userRegisterer;
	private $user;
	private $authenticator;

	public function __construct($url) {
		$this->userRepository = new UserRepository;
		if (isset($url) && count($url) > 1) {
			throw new Exception('Page Introuvable');
		}
		else if (!isset($_SESSION['logged'])) {
			header('Location: index.php');
		}
		else if ($this->json = file_get_contents('php://input')) {
			$this->actionDispatch();
		}
		else {
			$this->generateModifyView();
		}
	}

	private function actionDispatch() {
		$this->json = json_decode($this->json, TRUE);
		$this->user = ($this->userRepository->getUserById($_SESSION['logged']))[0];
		$this->userRegisterer = new UserRegisterer($this->user);
		if (isset($this->json['setInfo'])) {
			$this->setInfo();
		} elseif (isset($this->json['getInfo'])) {
			$this->sendInfo();
		} else if (isset($this->json['modifyPassword'])) {
			$this->password();
		}
		else if (isset($this->json['delete'])) {
			$this->delete();
		}
	}

	private function setInfo()
	{
		if ($this->json['username'] !== $this->user->username()) {
			$response [] = $this->userRegisterer->updateUserUsername($this->user, $this->json['username']);
		}
		if ($this->json['email'] !== $this->user->email()) {
			$response [] = $this->userRegisterer->updateUserEmail($this->user, $this->json['email']);
		}
		if ($this->json['notification'] !== $this->user->notifications()) {
			$response [] = $this->userRegisterer->updateUserNotifications($this->user, $this->json['notification']);
		}
		echo json_encode($response);
	}

	private function sendInfo()
	{
		$this->user = ($this->userRepository->getUserById($_SESSION['logged']))[0];
		echo json_encode(array(
			'username' => $this->user->username(),
			'email' => $this->user->email(),
			'notifications' => $this->user->notifications()
		));
	}

	private function username() {
		$response = $this->userRegisterer->updateUserUsername(
			$this->user,
			$this->json['new_username'],
			$this->json['password']
		);
		echo json_encode($response);
	}

	private function email() {
		$response = $this->userRegisterer->updateUserEmail(
			$this->user,
			$this->json['password'],
			$this->json['new_email']
		);
		echo json_encode($response);
	}

	private function password() {
		$response = $this->userRegisterer->updateUserPassword(
			$this->user,
			[$this->json['new_password1'], $this->json['new_password2']]
		);
		echo json_encode($response);
	}

	private function delete() {
		$response = $this->userRegisterer->deleteUser(
			$this->user,
			$this->json['password']
		);
		echo json_encode($response);
	}

	private function generateModifyView() {
		$this->user = ($this->userRepository->getUserById($_SESSION['logged']))[0];
		$this->viewGenerator = new ViewGenerator('Modify');
		$this->viewGenerator->generate(array('user' => $this->user));
	}
}

?>
