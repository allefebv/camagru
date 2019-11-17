<?php

class User extends Model {

	private $_id;
	private $_username;
	private $_password;
	private $_inscriptionDate;

	public function __construct(array $data) {
		$this->hydrate($data);
	}

	public function hydrate(array $data) {
		foreach ($data as $key => $value)
		{
			$setter = 'set' . ucfirst($key);
			if (method_exists($this->$setter))
				$this->$setter($value);
		}
	}

	//SETTERS
	public function setId($id) {
		$id = (int) $id;
		if ($id > 0)
			$this->_id = $id;
	}

	public function setUsername($username) {
		if (is_string($username))
			$this->_username = $username;
	}

	public function setPassword($password) {
			$this->_password = $password;
	}

	public function setInscriptionDate($inscriptionDate) {
		$inscriptionDate = (int) $inscriptionDate;
		if ($inscriptionDate > 0)
			$this->_inscriptionDate = $inscriptionDate;
	}

	//GETTERS
	public function id() {
		return $this->_id;
	}

	public function username() {
		return $this->_username;
	}

	public function password() {
		return $this->_password;
	}

	public function inscriptionDate() {
		return $this->_inscriptionDate;
	}

}

?>
