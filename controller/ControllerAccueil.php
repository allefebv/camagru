<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/Comment.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');

class ControllerAccueil {

	private $_commentManager;
	private $_view;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else
			$this->gallery();
	}

	private function gallery() {
		$this->$_commentManager = new CommentManager;
		$comments = $this->$_commentManager->getComments();
		$this->_view = new View('Accueil');
		$this->_view->generate(array('comments' => $comments));
	}
}

?>
