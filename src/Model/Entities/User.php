<?php

namespace Camagru\Model\Entities;

final class User extends AbstractEntity {

	private $id;
	private $username;
	private $password;
	private $registrationDate;
	private $email;
	private $key;
	private $activated;
	private $notifications;

	public function __construct(array $data)
	{
		parent::__construct($data);
	}

	public function __toString()
	{
		if ($this->username()) {
			return $this->username();
		} else {
			return 'Invalid User';
		}
	}

	public function activate()
	{
		$this->setActivated(1);
	}

	public function deactivate()
	{
		$this->setActivated(0);
	}

	//SETTERS
	protected function setUsername($username)
	{
		$this->username = $username;
	}

	protected function setNotifications($notifications)
	{
		$this->notifications = $notifications;
	}

	protected function setPassword($password)
	{
		$this->password = $password;
	}

	protected function setEmail($email)
	{
		$this->email = $email;
	}

	protected function setRegistrationDate($registrationDate)
	{
		$registrationDate = (int) $registrationDate;
		if ($registrationDate > 0) {
			$this->registrationDate = $registrationDate;
		}
	}

	protected function setId($id)
	{
		$this->id = $id;
	}

	protected function setKey($key)
	{
		$this->key = $key;
	}

	protected function setActivated(int $bool)
	{
		if ($bool === 1) {
			$this->activated = 1;
		} else {
			$this->activated = 0;
		}
	}

	//GETTERS
	public function id()
	{
		return $this->id;
	}

	public function key()
	{
		return $this->key;
	}

	public function activated()
	{
		return $this->activated;
	}

	public function status()
	{
		return $this->key;
	}

	public function username()
	{
		return $this->username;
	}

	public function password()
	{
		return $this->password;
	}

	public function registrationDate()
	{
		return $this->registrationDate;
	}

	public function email()
	{
		return $this->email;
	}

	public function notifications()
	{
		return (bool) $this->notifications;
	}
}

?>
