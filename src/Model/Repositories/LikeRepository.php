<?php

namespace Camagru\Model\Repositories;

use \Camagru\Model\Entities\Like;

require("config/database.php");

class LikeRepository extends BaseRepository {

	//table DB 'comments' et classe
	public function getLikes() {
		return $this->getAll('like', Like::class);
	}

	public function countImageLikes($imageId) {
		return $this->countByKey('like', Like::class, 'imageId', $imageId);
	}

	public function add(Like $like) {
		$req = $this->getDb()->prepare('INSERT INTO `like`(userId, imageId) VALUES(:userId, :imageId)');
		$req->execute(array('userId' => $like->userId(), 'imageId' => $like->imageId()));
	}

	public function delete(Like $like) {
		$req = $this->getDb()->prepare('DELETE
										FROM `like`
										WHERE userId = :userId AND imageId = :imageId');
		$req->execute(array('userId' => $like->userId(), 'imageId' => $like->imageId()));
	}

	public function likeStatus($array) {
		$req = $this->getDb()->prepare('SELECT userId, imageId
										FROM `like`
										WHERE userId = :userId AND imageId = :imageId ');
		$req->execute(array('userId' => $array['userId'], 'imageId' => $array['imageId']));
		$alreadyLiked = $req->fetch();
		return ($alreadyLiked ? 1 : 0);
	}

}

?>
