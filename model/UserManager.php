<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class UserManager extends Model {

	//table DB 'users' et classe 'User'
	public function getUsers() {
		return $this->getAll('user', 'User');
	}

	public function getUserByName($username) {
		return $this->getByKey('user', 'User', 'username', $username);
	}

	public function getUserById($id) {
		return $this->getByKey('user', 'User', 'id', $id);
	}

	public function add(User $user) {
		$req = $this->getDb()->prepare('INSERT INTO user(username, `password`, email) VALUES(:username, :password, :email)');
		$req->execute(array(
			'username' => $user->username(),
			'password' => hash('whirlpool', $user->password()),
			'email' => $user->email()));
	}

	public function delete(User $user) {

	}

	public function update(User $user) {

	}
}

?>
