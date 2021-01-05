<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\UserRepository;

class ControllerValidate {

    public function __construct($url)
    {
        if (isset($url) && count($url) > 1) {
            throw new Exception('Page Introuvable');
        }
        $this->confirmAccount();
    }

    private function confirmAccount()
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByActivationKey($_GET['user'])[0];
        if ($user) {
            $newKey = md5(uniqid());
            $user->activate();
            $userRepository->update($user, 'activated', $user->activated());
            $userRepository->update($user, 'activationKey', $newKey);
            $_GET['user'] = $newKey;
            header('Location: index.php?validation=true');
        } else {
            header('Location: index.php?validation=false');
        }
    } 

}