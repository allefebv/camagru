<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\UserRepository;
use Camagru\Service\ViewGenerator;
use \Exception;

class ControllerLogin {

	private $_viewGenerator;
	private $_userRepository;
	private $_user;

	public function __construct($url) 
	{
		$this->_userRepository = new UserRepository;
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
		$this->_user = ($this->_userRepository->getUserByEmail(htmlspecialchars($this->_json['email'])))[0];
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

	private function generateLoginView()
	{
		$this->_viewGenerator = new ViewGenerator('Login');

		if (isset($_GET['user'])) {
			$user = $this->_userRepository->getUserByKey($_GET['user'])[0];
			if ($user) {
				$activated = $user->activated();
				$this->_viewGenerator->generate(array('activated' => $activated));
			} else {
				$this->_viewGenerator->generate(array('linkError' => 1));
			}
		} else {
			$this->_viewGenerator->generate(array());
		}
	}

}

?>
