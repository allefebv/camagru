<?php

namespace Camagru\Controller;

use Camagru\Service\ViewGenerator;

class ControllerPassword {

    public function __construct($url)
    {
        if (isset($url) && count($url) > 1) {
            throw new Exception('Page Introuvable');
        }
    }

    private function sendResetMail()
    {

    }

    private function generatePasswordView()
    {
        $this->_viewGenerator = new ViewGenerator('Reset');
		$this->_viewGenerator->generate(array());
    }

}