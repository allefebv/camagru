<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\UserRepository;
use Camagru\Service\ViewGenerator;
use Camagru\Service\Emailer;
use Camagru\Service\PasswordGenerator;

class ControllerPassword {

    private $userRepository;
    private $user;
    private $json;

    public function __construct($url)
    {
        if (isset($url) && count($url) > 1) {
            throw new Exception('Page Introuvable');
        }
        $this->resetEmail();
    }

    private function resetEmail()
    {
        $this->json = file_get_contents('php://input');
        $this->json = json_decode($this->json, TRUE);
        $this->userRepository = new UserRepository();
        $this->user = ($this->userRepository->getUserByEmail($this->json['email']))[0];
		if (!$this->user) {
			echo json_encode(array('not_found_email' => 1));
		} else {
            $this->sendResetEmail();
        }
    }

    private function sendResetEmail()
    {
        $emailer = new Emailer();
        $passwordGenerator = new PasswordGenerator();
        $password = $passwordGenerator->generate();
        $this->userRepository->update($this->user, 'password', $password);
        $emailer->setEmailTemplate('ForgottenPassword');
        $emailer->generateEmail(array('user' => $this->user, 'password' => $password));
        $emailer->setRecipient($this->user->email());
		$emailer->send();
    }
}