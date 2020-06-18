<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\UserRepository;
use Camagru\Service\ViewGenerator;
use Camagru\Service\Authenticator;
use \Exception;

class ControllerLogin {

	private $viewGenerator;
	private $userRepository;
	private $user;
	private $authenticator;

	public function __construct($url) 
	{
		$this->userRepository = new UserRepository();
		$this->authenticator = new Authenticator();
		if (isset($url) && count($url) > 1) {
			throw new Exception('Page Introuvable');
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

	private function authUser()
	{
		$this->_json = json_decode($this->_json, TRUE);
		$this->user = ($this->userRepository->getUserByEmail($this->_json['email']))[0];
		$this->authenticator->setUser($this->user);
		if (!$this->user) {
			echo json_encode(array('incorrect_email' => 1));
		}
		else if (!$this->authenticator->isUserActivated()) {
			echo json_encode(array('inactive_account' => 1));
		}
		else if (!$this->authenticator->login($this->_json['password'])) {
			echo json_encode(array('incorrect_pwd' => 1));
		}
		else {
			echo json_encode(array('success' => 1));
		}
	}

	private function generateLoginView()
	{
		$this->viewGenerator = new ViewGenerator('Login');

		if (isset($_GET['user'])) {
			$user = $this->userRepository->getUserByKey($_GET['user'])[0];
			if ($user) {
				$activated = $user->activated();
				$this->viewGenerator->generate(array('activated' => $activated));
			} else {
				$this->viewGenerator->generate(array('linkError' => 1));
			}
		} else {
			$this->viewGenerator->generate(array());
		}
	}

}

?>
