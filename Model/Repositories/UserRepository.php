<?php

namespace \Camagru\Model\Repositories;

class UserRepository extends BaseRepository {

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

	public function getUserByEmail($email) {
		return $this->getByKey('user', 'User', 'email', $email);
	}

	public function add(User $user) {
		$req = $this->getDb()->prepare('INSERT INTO user(username, `password`, email) VALUES(:username, :password, :email)');
		$req->execute(array(
			'username' => $user->username(),
			'password' => hash('whirlpool', $user->password()),
			'email' => $user->email()));
	}

	public function delete(User $user) {
		return $this->deleteEntry('user', 'id', $user->id());
	}

	public function update(User $user, $updateFieldKey, $updateFieldValue) {
		if ($updateFieldKey === 'password') {
			return $this->updateEntry('user', $updateFieldKey, hash('whirlpool', $updateFieldValue), 'id', $user->id());
		}
		else {
			return $this->updateEntry('user', $updateFieldKey, $updateFieldValue, 'id', $user->id());
		}
	}
}

?>
