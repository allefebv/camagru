<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
/*
** The purpose of this class is to represent Comments
** Comments caracteristics and comments functionnalities
** hydratation with array of the private attributes
*/

class Comment {

	private $_id;
	private $_publicationDate;
	private $_userId;
	private $_imageId;
	private $_commentText;

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
	private function setId($id) {
		$id = (int) $id;
		if ($id > 0)
			$this->_id = $id;
	}

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
	public function id() {
		return $this->_id;
	}

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
