<?php

namespace Camagru\Controller;

use Camagru\Service\ViewGenerator;
use Camagru\Service\Emailer;

class ControllerPassword {

    public function __construct($url)
    {
        if (isset($url) && count($url) > 1) {
            throw new Exception('Page Introuvable');
        }

        
    }

    private function resetEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->generatePasswordView();
        } else {
            $this->sendResetEmail();
        }



    }

    private function sendResetEmail()
    {
        $emailer = new Emailer();
        $emailer->setEmailTemplate('ForgottenPassword');
        $emailer->generateEmail(array('user' => $_POST['email']));
        $emailer->setRecipient($this->user->email());
		$emailer->send();
    }

    private function generatePasswordView()
    {
        $this->_viewGenerator = new ViewGenerator('Reset');
		$this->_viewGenerator->generate(array());
    }

}