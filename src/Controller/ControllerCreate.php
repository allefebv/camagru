<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\UserRepository;
use Camagru\Model\Entities\User;
use Camagru\Service\ViewGenerator;
use Camagru\Service\EmailGenerator;
use Camagru\Service\Emailer;
use \Exception;

class ControllerCreate {

	private $_user;

	public function __construct($url)
	{
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (isset($_SESSION['logged'])) {
			throw new Exception('Vous êtes deja connecté');
		} else if (
			!isset($_POST['username'])
			&& !isset($_POST['password'])
			&& !isset($_POST['email'])) {
			$this->generateCreateView([]);
		} else {
			$this->createUser();
		}
	}

	private function createUser()
	{
		$key = md5(uniqid());
		$this->_user = new User(array(
							'username' => $_POST['username'],
							'password' => $_POST['password'],
							'email' => $_POST['email'],
							'key'	=> $key,
							));

		if (!$this->_user->isValid()) {
			$this->generateCreateView($this->_user->errors());
		} else {
			$userManager = new UserRepository;
			$userManager->add($this->_user);
			$this->sendConfirmationEmail();
			header('Location: index.php');
		}
		$_POST = array();
	}

	private function generateCreateView($array)
	{
		$viewGenerator = new ViewGenerator('Create');
		$viewGenerator->generate($array);
	}

	private function sendConfirmationEmail()
	{
		$emailer = new Emailer();
		$emailer->setEmailTemplate('AccountConfirmation');
		$emailer->generateEmail(array('user' => $this->_user));
		$emailer->setRecipient($this->_user->email());
		$emailer->send();
	}

}

?>
