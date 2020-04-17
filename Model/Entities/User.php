<?php

namespace Camagru\Model\Entities;

use \Camagru\Model\Repositories\LikeRepository;
use \Camagru\Model\Repositories\CommentRepository;

final class User extends AbstractEntity {

	private $_id;
	private $_username;
	private $_password;
	private $_inscriptionDate;
	private $_email;
	private $_commentManager;
	private $_errors=array();

	public function __construct(array $data) {
		parent::__construct($data);
	}

	//SETTERS
	protected function setUsername($username) {
		if (!empty($username) && is_string($username))
			$this->_username = $username;
		else
			$this->setErrors('username');
	}

	protected function setPassword($password) {
		$this->_password = $password;
	}

	protected function setEmail($email) {
		if (!empty($email) && is_string($email))
			$this->_email = $email;
		else
			$this->setErrors('email');
	}

	//specific setters for DB retrieving
	protected function setInscriptionDate($inscriptionDate) {
		$inscriptionDate = (int) $inscriptionDate;
		if ($inscriptionDate > 0)
			$this->_inscriptionDate = $inscriptionDate;
	}

	protected function setId($id) {
		$id = (int)$id;
		if ($id > 0)
			$this->_id = $id;
	}

	//setter for errors
	protected function setErrors($error) {
		echo $error;
		$this->_errors[$error] = $error;
	}

	//GETTERS
	public function id() {
		return $this->_id;
	}

	public function username() {
		return $this->_username;
	}

	public function password() {
		return $this->_password;
	}

	public function registrationDate() {
		return $this->_registrationDate;
	}

	public function email() {
		return $this->_email;
	}

	public function errors() {
		return $this->_errors;
	}

	//SPECIFIC METHODS
	public function login($password) {
		if (hash('whirlpool', $password) === $this->password()) {
			$_SESSION['logged'] = $this->id();
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function verifyPassword($password) {
		if (hash('whirlpool', $password) === $this->password()) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function logout() {
		unset($_SESSION['logged']);
		session_destroy();
	}

	public function isValid() {
		if (empty($this->errors()))
			return TRUE;
		return FALSE;
	}

	public function postComment(array $data) {
		$this->_commentManager = new CommentManager;
		$this->_commentManager->add(
			new Comment(array(	'commentText' => $data['commentText'],
								'imageId' => $data['imageId'],
								'userId' => $this->id())));
	}

	public function likeImage(array $data) {
		$this->_likeManager = new LikeManager;
		$pair = ['userId' => $this->id(), 'imageId' => $data['imageId']];
		if ($this->_likeManager->likeStatus($pair) === 1) {
			$this->_likeManager->delete(new Like($pair));
		}
		else {
			$this->_likeManager->add(new Like($pair));
		}
	}

	public function __toString() {
		if ($this->username())
			return $this->username();
		else
			return 'Invalid User';
	}
}

?>
