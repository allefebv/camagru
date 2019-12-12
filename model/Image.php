<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class Image {

	private $_id;
	private $_userId;
	private $_pathToImage;
	private $_publicationDate;
	private $_comments=array();
	private $_likes;

	public function __construct(array $data) {
		$this->hydrate($data);
		$this->setComments();
		$this->setLikes();
	}

	private function hydrate(array $data) {
		foreach ($data as $key => $value)
		{
			$setter = 'set' . ucfirst($key);
			if (method_exists($this, $setter))
				$this->$setter($value);
		}
	}

	//SETTERS
	private function setId($id) {
		$id = (int) $id;
		if ($id > 0)
			$this->_id = $id;
	}

	private function setPublicationDate($publicationDate) {
		$this->_publicationDate = $publicationDate;
	}

	public function setPathToImage($pathToImage) {
		if (is_string($pathToImage))
			$this->_pathToImage = $pathToImage;
	}

	public function setUserId($userId) {
		$userId = (int) $userId;
		if ($userId > 0)
			$this->_userId = $userId;
	}

	public function setComments() {
		$commentManager = new CommentManager;
		$this->_comments = $commentManager->getImageComments($this->id());
	}

	public function setLikes() {
		$likeManager = new LikeManager;
		$this->_likes = (int)$likeManager->countImageLikes($this->id())['COUNT(*)'];
	}

	//GETTERS
	public function pathToImage() {
		return $this->_pathToImage;
	}

	public function id() {
		return $this->_id;
	}

	public function userId() {
		return $this->_userId;
	}

	public function publicationDate() {
		return $this->_publicationDate;
	}

	public function comments() {
		return $this->_comments;
	}

	public function likes() {
		return $this->_likes;
	}
}
