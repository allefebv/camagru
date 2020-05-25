<?php

namespace Camagru\Service;

use Camagru\Model\Entities\User;

class Authenticator {

    private $user;

    public function __construct(User $user = null)
    {
		if ($user) {
			$this->setUser($user);
		}
    }

	public function isUserActivated()
	{
		if ($this->user->activated()) {
			return TRUE;
		}
		
		return FALSE;
	}

    public function login(string $password)
	{
		if (hash('whirlpool', $password) === $this->user->password()) {
			$_SESSION['logged'] = $this->user->id();
			return TRUE;
		}
		
		return FALSE;
	}

	public function verifyPassword(string $password)
	{
		if (hash('whirlpool', $password) === $this->user->password()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function logout()
	{
		unset($_SESSION['logged']);
		session_destroy();
    }
    
    public function setUser(User $user)
    {
        $this->user = $user;
    }
    
}