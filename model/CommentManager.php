<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class CommentManager extends Model {

	//table DB 'comments' et classe
	public function getComments() {
		return $this->getAll('comment', 'Comment');
	}

	public function getComment($id) {

	}

	public function add(Comment $comment) {

	}

	public function delete(Comment $comment) {

	}

	public function update(Comment $comment) {

	}
}

?>
