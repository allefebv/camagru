<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\UserRepository;

class ControllerValidate {

    //logique pour activer le compte
    //vue vers la page de login

    public function __construct($url)
    {
        if (isset($url) && count($url) > 1) {
            throw new Exception('Page Introuvable');
        }
        $this->confirmAccount();
        new ControllerLogin($url);
    }

    private function confirmAccount()
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByKey($_GET['user'])[0];
        if ($user) {
            $user->activate();
            $userRepository->update($user, 'activated', $user->activated());
            $userRepository->update($user, '`key`', md5(uniqid()));
        }
    } 

}