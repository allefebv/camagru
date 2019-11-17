<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
/*
** The purpose of this class is to represent Comments
** Comments caracteristics and comments functionnalities
** hydratation with array of the private attributes
*/

class Comment {

	private $_id;
	private $_text;
	private $_author;
	private $_time;

	public function __construct(array $data) {
		$this->hydrate($data);
	}

	public function hydrate(array $data) {
		foreach ($data as $key => $value)
		{
			$setter = 'set' . ucfirst($key);
			if (method_exists($this, $setter))
				$this->$setter($value);
		}
	}

	//SETTERS
	public function setId($id) {
		$id = (int) $id;
		if ($id > 0)
			$this->_id = $id;
	}

	public function setText($text) {
		if (is_string($text))
			$this->_text = $text;
	}

	public function setAuthor($author) {
		if (is_string($author))
			$this->_author = $author;
	}

	public function setTime($time) {
		$this->_date = $date;
	}

	//GETTERS
	public function id() {
		return $this->_id;
	}

	public function text() {
		return $this->_text;
	}

	public function author() {
		return $this->_author;
	}

	public function time() {
		return $this->_time;
	}

}

?>
