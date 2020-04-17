<?php

namespace Camagru\Model\Entities;

final class Like extends AbstractEntity{

	private $_likeDate;
	private $_userId;
	private $_imageId;

	public function __construct(array $data) {
		parent::__construct($data);
	}

	//SETTERS
	protected function setLikeDate($likeDate) {
		$this->_likeDate = $likeDate;
	}

	protected function setUserId($userId) {
		$this->_userId = (int)$userId;
	}

	protected function setImageId($imageId) {
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
