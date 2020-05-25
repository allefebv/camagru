<?php

namespace Camagru\Model\Entities;

use Camagru\Model\Repositories\LikeRepository;
use Camagru\Model\Repositories\CommentRepository;
use Camagru\Model\Entities\Comment;
use Camagru\Model\Entities\Like;

final class User extends AbstractEntity {

	private $id;
	private $username;
	private $password;
	private $registrationDate;
	private $email;
	private $commentRepository;
	private $key;
	private $activated;

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

	public function postComment(array $data)
	{
		$this->commentRepository = new CommentRepository;
		$this->commentRepository->add(
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

	//SETTERS
	protected function setUsername($username)
	{
		$this->username = $username;
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
}

?>
