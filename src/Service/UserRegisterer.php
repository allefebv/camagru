<?php

namespace Camagru\Service;

use Camagru\Model\Repositories\UserRepository;
use Camagru\Model\Entities\User;
use Camagru\Service\Emailer;
use Camagru\Service\EmailGenerator;
use Camagru\Service\Authenticator;

class UserRegisterer {

    private $userRepository;
    private $validator;
    private $user;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->validator = new Validator($this->userRepository);
        $this->authenticator = new Authenticator();
    }

    public function updateUserUsername(User $user, string $username)
    {
        $response['username'] = 1;
        if (!$this->validator->isAvailableUsername($username)) {
            $response['error_unavailable_username'] = 1;
        } else if (!$this->userRepository->update($user, 'username', $username)){
			$response['error_db'] = 1;
		} else {
			$response['success'] = 1;
        }
        return $response;
    }

    public function updateUserEmail(User $user, string $email)
    {
        $response['email'] = 1;
        if (!$this->validator->isValidEmail($email)) {
            $response['error_format_email'] = 1;
        } else if (!$this->userRepository->update($user, 'email', $this->json['newEmail'])){
			$response['error_db'] = 1;
		} else {
			$response['success'] = 1;
        }
        return $response;
    }

    public function updateUserPassword(User $user, string $oldPassword, array $newPassword)
    {
        $response['password'] = 1;
        $this->authenticator->setUser($user);
        if (!$this->authenticator->verifyPassword($oldPassword)) {
            $response['error_current_pwd'] = 1;
        } else if (!$this->validator->isValidPassword($newPassword[0])) {
			$response['error_format_new_pwd'] = 1;
		} else if ($newPassword[0] !== $newPassword[1]) {
			$response['error_diff_new_pwd'] = 1;
		} else if (!$this->userRepository->update($user, 'pwd', $this->json['newPassword1'])){
			$response['error_db'] = 1;
		} else {
			$response['success'] = 1;
        }
        return $response;
    }

    public function registerUser(array $json)
    {
        $errors['invalid_username'] = !$this->validator->isValidUsername($json['username']);
        $errors['invalid_email'] = !$this->validator->isValidEmail($json['email']);
        $errors['invalid_pwd'] = !$this->validator->isValidPassword($json['password']);
        $errors['non_matching_pwds'] = !$this->validator->areIdenticalPasswords($json['password'], $json['passwordconfirm']);
        $errors['duplicate_username'] = !$this->validator->isAvailableUsername($json['username']);
        $errors['duplicate_email'] = !$this->validator->isAvailableEmail($json['email']);
        foreach ($errors as $error) {
            if (true === $error) {
                return array_filter($errors, function($item) { return $item; });
            }
        }
        $this->createUser($json);
        $this->sendConfirmationEmail();
        $this->userRepository->add($this->user);
        return null;
    }

    private function createUser(array $json)
    {
        $key = md5(uniqid());
        $this->user = new User([
            'username' => $json['username'],
            'password' => hash('whirlpool', $json['password']),
            'email' => $json['email'],
            'key'	=> $key,
        ]);
    }

    private function sendConfirmationEmail()
	{
		$emailer = new Emailer();
		$emailer->setEmailTemplate('AccountConfirmation');
		$emailer->generateEmail(array('user' => $this->user));
		$emailer->setRecipient($this->user->email());
		$emailer->send();
    }
    
    private function resendConfirmationEmail(User $user)
    {
        $this->user = $user;
        $key = md5(uniqid());
        $this->userRepository->update($user, 'key', $key);
        $emailer = new Emailer();
		$emailer->setEmailTemplate('AccountConfirmation');
		$emailer->generateEmail(array('user' => $this->user));
		$emailer->setRecipient($this->user->email());
		$emailer->send();
    }

}