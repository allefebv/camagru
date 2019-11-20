<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class UserManager extends Model {

	//table DB 'users' et classe 'User'
	public function getUsers() {
		return $this->getAll('users', 'User');
	}

	public function getUserByName($username) {
		return $this->getOneBy('users', 'User', 'username', $username);
	}

	public function getUserByEmail($email) {

	}

	public function add(User $user) {
		$req = $this->getDb()->prepare('INSERT INTO users(username, `password`, email) VALUES(:username, :password, :email)');
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
