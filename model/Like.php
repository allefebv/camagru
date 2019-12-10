<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class Comment {

	private $_likeDate;
	private $_userId;
	private $_imageId;

	public function __construct(array $data) {
		$this->hydrate($data);
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
	private function setLikeDate($likeDate) {
		$this->_likeDate = $likeDate;
	}

	public function setUserId($userId) {
		if (is_string($userId))
			$this->_userId = $userId;
	}

	public function setImageId($imageId) {
		if (is_string($imageId))
			$this->_imageId = $imageId;
	}

	//GETTERS
	public function likeDate() {
		return $this->_likeDate;
	}

	public function userId() {
		return $this->_userId;
	}

	public function imageId() {
		return $this->_imageId;
	}

}

?>
