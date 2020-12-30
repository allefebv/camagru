<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\UserRepository;
use Camagru\Service\ViewGenerator;
use Camagru\Service\Authenticator;
use \Exception;

class ControllerSignin {

	private $userRepository;
	private $user;
	private $authenticator;
	private $json;

	public function __construct($url) 
	{
		$this->userRepository = new UserRepository();
		$this->authenticator = new Authenticator();
		if (isset($url) && count($url) > 1) {
			throw new Exception('Page Introuvable');
		} else if (isset($_SESSION['logged'])) {
			header('Location: index.php');
		} else if ($this->json = file_get_contents('php://input')) {
			$this->authUser();
		}
	}

	private function authUser()
	{
		$this->json = json_decode($this->json, TRUE);
		$this->user = ($this->userRepository->getUserByEmail($this->json['email']))[0];
		$this->authenticator->setUser($this->user);
		header('Content-Type: application/json');
		if (!$this->user) {
			echo json_encode(array('incorrect_email' => 1));
		} else if (!$this->authenticator->isUserActivated()) {
			echo json_encode(array('inactive_account' => 1));
		} else if (!$this->authenticator->signin(htmlspecialchars($this->json['password']))) {
			echo json_encode(array('incorrect_pwd' => 1));
		} else {
			echo json_encode(array('success' => 1, 'username' => $this->user->username(), 'userId' => $this->user->id()));
		}
	}
}

?>
