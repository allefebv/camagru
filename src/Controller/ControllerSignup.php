<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\UserRepository;
use Camagru\Service\ViewGenerator;
use Camagru\Service\UserRegisterer;
use \Exception;

class ControllerSignup {

	private $userRegisterer;
	private $userRepository;
	private $json;

	public function __construct($url)
	{
		$this->userRegisterer = new UserRegisterer();
		$this->userRepository = new UserRepository();

		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (isset($_SESSION['logged'])) {
			throw new Exception('Vous êtes deja connecté');
		} else if ($this->json = file_get_contents('php://input')) {
			$this->actionDispatch();
		}
	}

	private function actionDispatch()
	{
		$this->json = json_decode($this->json, TRUE);

		if (isset($this->json['signup'])) {
			$this->createUser();
		} else if (isset($this->json['resendLink'])) {
			$this->resendActivationLink();
		}
	}

	private function createUser()
	{
		$errors = $this->userRegisterer->registerUser($this->json);
		if ($errors) {
			echo json_encode($errors);
		} else {
			echo json_encode(array('success' => 1));
		}
	}

	private function resendActivationLink()
	{
		$user = ($this->userRepository->getUserByEmail($this->json['email']))[0];
		if (!$user) {
			echo json_encode(array('error' => 'not_found_email'));
		} else {
			$this->userRegisterer->resendConfirmationEmail($user);
			echo json_encode(array('success' => 'email_sent'));
        }
		
	}
}

?>
