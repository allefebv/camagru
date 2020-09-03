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

    public function signin(string $password)
	{
		if (hash('whirlpool', $password) === $this->user->password()) {
			$_SESSION['logged'] = $this->user->id();
			$_SESSION['username'] = $this->user->username();
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
		unset($_SESSION['username']);
		session_destroy();
    }
    
    public function setUser(?User $user)
    {
        $this->user = $user;
    }
    
}