<?php

namespace Camagru\Model\Entities;

class Like extends AbstractEntity{

	private $_likeDate;
	private $_userId;
	private $_imageId;

	//SETTERS
	private function setLikeDate($likeDate) {
		$this->_likeDate = $likeDate;
	}

	public function setUserId($userId) {
		$this->_userId = (int)$userId;
	}

	public function setImageId($imageId) {
		$this->_imageId = (int)$imageId;
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
