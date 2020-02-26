<?php

namespace Camagru\Model\Entities;

/*
** The purpose of this class is to represent Comments
** Comments caracteristics and comments functionnalities
** hydratation with array of the private attributes
*/

class Comment extends AbstractEntity {

	private $_publicationDate;
	private $_userId;
	private $_imageId;
	private $_commentText;

	//SETTERS
	private function setPublicationDate($publicationDate) {
		$this->_publicationDate = $publicationDate;
	}

	public function setUserId($userId) {
			$this->_userId = (int)$userId;
	}

	public function setImageId($imageId) {
			$this->_imageId = (int)$imageId;
	}

	public function setCommentText($commentText) {
		if (is_string($commentText))
			$this->_commentText = $commentText;
	}

	//GETTERS
	public function publicationDate() {
		return $this->_publicationDate;
	}

	public function userId() {
		return $this->_userId;
	}

	public function imageId() {
		return $this->_imageId;
	}

	public function commentText() {
		return $this->_commentText;
	}

}

?>
