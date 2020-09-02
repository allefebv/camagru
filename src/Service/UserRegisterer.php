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

    public function __construct(User $user = null)
    {
        $this->userRepository = new UserRepository();
        $this->validator = new Validator($this->userRepository);
        $this->authenticator = new Authenticator($user);
    }

    public function updateUserUsername(User $user, string $username)
    {
        if (!$this->validator->isAvailableUsername($username)) {
            $response['error'] = 'duplicate_username';
        } else if (!$this->userRepository->update($user, 'username', $username)){
			$response['error'] = 'database_error';
		} else {
			$response['success'] = 'updated_username';
        }
        return $response;
    }

    public function updateUserEmail(User $user, string $email)
    {
        if (!$this->validator->isValidEmail($email)) {
            $response['error'] = 'invalid_email';
        } else if (!$this->userRepository->update($user, 'email', $email)){
			$response['error'] = 'database_error';
		} else {
			$response['success'] = 'updated_email';
        }
        return $response;
    }

    public function updateUserNotifications(User $user, bool $notif)
    {
        $notif = $notif ? 1 : 0;
        if (!$this->userRepository->update($user, 'notifications', $notif)){
			$response['error'] = 'database_error';
		} else {
			$response['success'] = 'updated_notifications';
        }
        return $response;
    }

    public function updateUserPassword(User $user, array $newPassword)
    {
        if (!$this->validator->isValidPassword($newPassword[0])) {
			$response['error'] = 'invalid_pwd';
		} else if ($newPassword[0] !== $newPassword[1]) {
			$response['error'] = 'non_matching_pwds';
		} else if (!$this->userRepository->update($user, 'password', $newPassword[0])){
			$response['error'] = 'database_error';
		} else {
			$response['success'] = 'updated_password';
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

    public function deleteUser($user, $password)
    {
        if (!$this->authenticator->verifyPassword($password)) {
			$response['error'] = 'incorrect_pwd';
		}
		else if (!$this->userRepository->delete($user)) {
			$response['error'] = 'database_error';
		}
		else {
			$response['success'] = 'account_deleted';
			$this->authenticator->logout();
        }
        return $response;
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