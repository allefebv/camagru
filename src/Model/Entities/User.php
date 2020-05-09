<?php

namespace Camagru\Model\Entities;

use Camagru\Model\Repositories\LikeRepository;
use Camagru\Model\Repositories\CommentRepository;
use Camagru\Model\Entities\Comment;
use Camagru\Model\Entities\Like;

final class User extends AbstractEntity {

	private $_id;
	private $_username;
	private $_password;
	private $_registrationDate;
	private $_email;
	private $_commentManager;
	private $_key;
	private $_activated;
	private $_errors=array();

	public function __construct(array $data)
	{
		parent::__construct($data);
	}

	//SPECIFIC METHODS
	public function login($password)
	{
		if (hash('whirlpool', $password) === $this->password()) {
			$_SESSION['logged'] = $this->id();
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function verifyPassword($password)
	{
		if (hash('whirlpool', $password) === $this->password()) {
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

	public function isValid()
	{
		if (empty($this->errors())) {
			return TRUE;
		}
		return FALSE;
	}

	public function activate()
	{
		$this->setActivated(true);
	}

	public function deactivate()
	{
		$this->setActivated(false);
	}

	public function postComment(array $data)
	{
		$this->_commentManager = new CommentRepository;
		$this->_commentManager->add(
			new Comment(array(	'commentText' => $data['commentText'],
								'imageId' => $data['imageId'],
								'userId' => $this->id())));
	}

	public function likeImage(array $data)
	{
		$this->_likeManager = new LikeRepository;
		$pair = ['userId' => $this->id(), 'imageId' => $data['imageId']];
		if ($this->_likeManager->likeStatus($pair) === 1) {
			$this->_likeManager->delete(new Like($pair));
		} else {
			$this->_likeManager->add(new Like($pair));
		}
	}

	public function __toString()
	{
		if ($this->username()) {
			return $this->username();
		} else {
			return 'Invalid User';
		}
	}

	//SETTERS
	protected function setUsername($username)
	{
		if (!empty($username) && is_string($username)) {
			$this->_username = $username;
		}
		else {
			$this->setErrors('username');
		}
	}

	protected function setPassword($password)
	{
		$this->_password = $password;
	}

	protected function setEmail($email)
	{
		if (!empty($email) && is_string($email)) {
			$this->_email = $email;
		} else {
			$this->setErrors('email');
		}
	}

	//specific setters for DB retrieving
	protected function setRegistrationDate($registrationDate)
	{
		$registrationDate = (int) $registrationDate;
		if ($registrationDate > 0) {
			$this->_inscriptionDate = $registrationDate;
		}
	}

	protected function setId($id)
	{
		$id = (int)$id;
		if ($id > 0) {
			$this->_id = $id;
		}
	}

	protected function setKey($key)
	{
		$this->_key = $key;
	}

	protected function setActivated(bool $bool)
	{
		if ($bool === true) {
			$this->_activated = 1;
		} else {
			$this->_activated = 0;
		}
	}

	//setter for errors
	protected function setErrors($error)
	{
		$this->_errors[$error] = $error;
	}

	//GETTERS
	public function id()
	{
		return $this->_id;
	}

	public function key()
	{
		return $this->_key;
	}

	public function activated()
	{
		return $this->_activated;
	}

	public function status()
	{
		return $this->_key;
	}

	public function username()
	{
		return $this->_username;
	}

	public function password()
	{
		return $this->_password;
	}

	public function registrationDate()
	{
		return $this->_registrationDate;
	}

	public function email()
	{
		return $this->_email;
	}

	public function errors()
	{
		return $this->_errors;
	}
}

?>
