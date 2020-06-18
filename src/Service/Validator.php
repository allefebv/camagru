<?php

namespace Camagru\Service;


use Camagru\Model\Repositories\UserRepository;

class Validator {

    const EMAIL_REGEX = '/^(\w+|\w+.*\w+)@(\w+|\w+.*\w+)$/';
    const PASSWORD_REGEX = '/(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@?!*]).{8,}/';
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isValidUsername(string $username)
    {
        if (!isset($username) || empty($username)) {
            return false;
        }

        return true;
    }

    public function isValidEmail(string $email)
    {
        if (!isset($_POST['email'])
        || empty($_POST['email'])
        || !preg_match(self::EMAIL_REGEX, $_POST['email'])) {
            return false;
        }

        return true;
    }

    public function isValidPassword(string $password)
    {
        if (!isset($_POST['password'])
        || empty($_POST['password'])
        || !preg_match(self::PASSWORD_REGEX, $_POST['password'])) {
            return false;
        }

        return true;
    }

    public function isAvailableUsername(string $password)
    {
        if ($this->userRepository->getUserByName($_POST['username'])) {
            return false;
        }

        return true;
    }

    public function isAvailableEmail(string $email)
    {
        if ($this->userRepository->getUserByEmail($_POST['email'])) {
            return false;
        }

        return true;
    }

}