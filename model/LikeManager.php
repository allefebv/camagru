<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class LikeManager extends Model {

	//table DB 'comments' et classe
	public function getLikes() {
		return $this->getAll('like', 'Like');
	}

	public function getImageLikes($imageId) {
		return $this->getByKey('like', 'Like', 'imageId', $imageId);
	}

	public function add(Like $like) {
		$req = $this->getDb()->prepare('INSERT IGNORE INTO like(userId, imageId) VALUES(:userId, :imageId)');
		$req->execute(array('userId' => $like->userId(), 'imageId' => $like->imageId()));
	}

	public function delete(Like $like) {

	}

}

?>
