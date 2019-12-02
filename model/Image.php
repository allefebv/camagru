<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class Image {

	private $_id;
	private $_pathToImage;
	private $_publicationDate;
	private $_likeCounter;
	private $_comments=array();

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
	public function setPathToImage($pathToImage) {
		if (is_string($pathToImage))
			$this->_pathToImage = $pathToImage;
	}

	public function setId($id) {
		$id = (int) $id;
		if ($id > 0)
			$this->_id = $id;
	}

	public function setPublicationDate($publicationDate) {
		$this->_publicationDate = $publicationDate;
	}

	//GETTERS
	public function pathToImage() {
		return $this->_pathToImage;
	}

	public function id() {
		return $this->_id;
	}

	public function publicationDate() {
		return $this->_publicationDate;
	}
}
