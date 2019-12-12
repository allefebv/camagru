<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class CommentManager extends Model {

	//table DB 'comments' et classe
	public function getComments() {
		return $this->getAll('comment', 'Comment');
	}

	public function getImageComments($imageId) {
		return $this->getByKey('comment', 'Comment', 'imageId', $imageId);
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
