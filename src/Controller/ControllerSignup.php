<?php

namespace Camagru\Controller;

use Camagru\Service\ViewGenerator;
use Camagru\Service\UserRegisterer;
use \Exception;

class ControllerSignup {

	private $userRegisterer;
	private $json;

	public function __construct($url)
	{
		$this->userRegisterer = new UserRegisterer();

		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (isset($_SESSION['logged'])) {
			throw new Exception('Vous êtes deja connecté');
		} else if ($this->json = file_get_contents('php://input')) {
			$this->createUser();
		}
	}

	private function createUser()
	{
		$this->json = json_decode($this->json, TRUE);
		$errors = $this->userRegisterer->registerUser($this->json);
		if ($errors) {
			echo json_encode($errors);
		} else {
			echo json_encode(array('success' => 1));
		}
	}
}

?>
