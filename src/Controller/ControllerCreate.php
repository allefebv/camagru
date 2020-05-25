<?php

namespace Camagru\Controller;

use Camagru\Service\ViewGenerator;
use Camagru\Service\UserRegisterer;
use \Exception;

class ControllerCreate {

	private $userRegisterer;

	public function __construct($url)
	{
		$this->userRegisterer = new UserRegisterer();

		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (isset($_SESSION['logged'])) {
			throw new Exception('Vous êtes deja connecté');
		} else {
			$this->createUser();
		}
	}

	private function createUser()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$errors = $this->userRegisterer->registerUser();
			if ($errors) {
				$this->generateCreateView($errors);
			} else {
				header('Location: index.php');
			}
			$_POST = [];
		} else {
			$this->generateCreateView([]);
		}
	}

	private function generateCreateView($array)
	{
		$viewGenerator = new ViewGenerator('Create');
		$viewGenerator->generate($array);
	}

}

?>
