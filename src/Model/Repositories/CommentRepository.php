<?php

namespace Camagru\Model\Repositories;

use Camagru\Model\Entities\Comment;

require("config/database.php");

class CommentRepository extends BaseRepository {

	//table DB 'comments' et classe
	public function getComments() {
		return $this->getAll('comment', Comment::class);
	}

	public function getImageComments($imageId) {
		return $this->getByKey('comment', Comment::class, 'imageId', $imageId);
	}

	public function getImageCommentsByPublicationDate($imageId) {
		return $this->getByKeyOrderByKey('comment', Comment::class, 'imageId', $imageId, 'publicationDate', 'asc');
	}

	public function getExposedComments(array $comments) {
		return $this->getExposedObjects($comments);
	}

	public function add(Comment $comment) {
		if (!empty($comment->commentText())) {
			$req = $this->getDb()->prepare('INSERT INTO `comment`(userId, imageId, commentText) VALUES(:userId, :imageId, :commentText)');
			$req->execute(array('userId' => $comment->userId(), 'imageId' => $comment->imageId(), 'commentText' => $comment->commentText()));
		}
	}

	public function delete(Comment $comment) {

	}

	public function update(Comment $comment) {

	}
}

?>
