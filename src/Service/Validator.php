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

    public function areIdenticalPasswords(string $password, string $passwordconfirm)
    {
        if (!isset($password)
        || empty($password)
        || !isset($passwordconfirm)
        || empty($passwordconfirm)
        || $password !== $passwordconfirm) {
            return false;
        }
        return true;
    }

    public function isValidEmail(string $email)
    {
        if (empty($email) || !preg_match(self::EMAIL_REGEX, $email)) {
            return false;
        }
        return true;
    }

    public function isValidPassword(string $password)
    {
        if (empty($password) || !preg_match(self::PASSWORD_REGEX, $password)) {
            return false;
        }
        return true;
    }

    public function isAvailableUsername(string $username)
    {
        if ($this->userRepository->getUserByName($username)) {
            return false;
        }
        return true;
    }

    public function isAvailableEmail(string $email)
    {
        if ($this->userRepository->getUserByEmail($email)) {
            return false;
        }
        return true;
    }

}