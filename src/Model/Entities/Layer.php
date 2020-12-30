<?php

namespace Camagru\Model\Entities;

final class Layer extends AbstractEntity {

	private $_id;
	private $_pathToLayer;

	public function __construct(array $data) {
		parent::__construct($data);
	}

	//SETTERS
	protected function setId($id) {
		$id = (int)$id;
		if ($id > 0)
			$this->_id = $id;
	}

	protected function setPathToLayer($pathToLayer) {
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

	public function expose() {
		return get_object_vars($this);
	}
}
