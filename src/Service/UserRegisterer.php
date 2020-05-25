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

    public function updateUserUsername(User $user, string $username, string $pwd)
    {
        $response['username'] = 1;
        $this->authenticator->setUser($user);
        if (!$this->authenticator->verifyPassword($pwd)) {
            $response['error_pwd'] = 1;
        } else if (!$this->validator->isValidUsername($username)) {
            $response['error_format_username'] = 1;
        } else if (!$this->userRepository->update($this->user, 'username', $this->json['newEmail'])){
			$response['error_db'] = 1;
		} else {
			$response['success'] = 1;
        }
        return $response;
    }

    public function updateUserEmail(User $user, string $email, string $pwd)
    {
        $response['email'] = 1;
        $this->authenticator->setUser($user);
        if (!$this->authenticator->verifyPassword($pwd)) {
            $response['error_pwd'] = 1;
        } else if (!$this->validator->isValidEmail($email)) {
            $response['error_format_email'] = 1;
        } else if (!$this->userRepository->update($this->user, 'email', $this->json['newEmail'])){
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
		} else if (!$this->userRepository->update($this->user, 'pwd', $this->json['newPassword1'])){
			$response['error_db'] = 1;
		} else {
			$response['success'] = 1;
        }
        return $response;
    }

    public function registerUser()
    {
        $errors['invalid_username'] = !$this->validator->isValidUsername($_POST['username']);
        $errors['invalid_email'] = !$this->validator->isValidEmail($_POST['email']);
        $errors['invalid_pwd'] = !$this->validator->isValidPassword($_POST['password']);
        $errors['duplicate_username'] = !$this->validator->isAvailableUsername($_POST['username']);
        $errors['duplicate_email'] = !$this->validator->isAvailableEmail($_POST['email']);
        foreach ($errors as $error) {
            if (true === $error) {
                return $errors;
            }
        }
        $this->createUser();
        $this->sendConfirmationEmail();
        $this->userRepository->add($this->user);
        return null;
    }

    private function createUser()
    {
        $key = md5(uniqid());
        $this->user = new User([
            'username' => $_POST['username'],
            'password' => hash('whirlpool', \htmlspecialchars($_POST['password'])),
            'email' => $_POST['email'],
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

}