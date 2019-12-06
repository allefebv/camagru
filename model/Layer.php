<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class Layer {

	private $_id;
	private $_pathToLayer;

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
	public function setPathToLayer($pathToLayer) {
		if (is_string($pathToLayer))
			$this->_pathToLayer = $pathToLayer;
	}

	public function setId($id) {
		$id = (int) $id;
		if ($id > 0)
			$this->_id = $id;
	}

	//GETTERS
	public function pathToLayer() {
		return $this->_pathToLayer;
	}

	public function id() {
		return $this->_id;
	}
}
