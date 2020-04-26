<?php

namespace Camagru\Model\Entities;

abstract class AbstractEntity {

	public function __construct(array $data) {
		$this->hydrate($data);
	}

    protected function hydrate(array $data) {
		foreach ($data as $key => $value)
		{
			$setter = 'set' . ucfirst($key);
			if (method_exists($this, $setter))
				$this->$setter($value);
		}
    }

}