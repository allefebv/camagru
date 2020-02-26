<?php

namespace Camagru\Model\Entities;

class Layer extends AbstractEntity {

	private $_id;
	private $_pathToLayer;

	//SETTERS
	private function setId($id) {
		$id = (int)$id;
		if ($id > 0)
			$this->_id = $id;
	}

	public function setPathToLayer($pathToLayer) {
		if (is_string($pathToLayer))
			$this->_pathToLayer = $pathToLayer;
	}

	//GETTERS
	public function id() {
		return $this->_id;
	}

	public function pathToLayer() {
		return $this->_pathToLayer;
	}

}
