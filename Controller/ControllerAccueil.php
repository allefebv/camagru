<?php

namespace Camagru\Controller;

use \Camagru\Model\Repositories\ImageRepository;
use \Camagru\Model\Repositories\UserRepository;
use \Camagru\View\View;

class ControllerAccueil {

	private $_imageManager;
	private $_userManager;
	private $_user;
	private $_view;
	private $_json;

	public function __construct($url) {
		if (((is_array($url) || $url instanceof countable)
			&& count($url)) && count($url) > 1)
			throw new \Exception('Page Introuvable');
		else if ($this->_json = file_get_contents('php://input'))
			$this->likeComment();
		else
			$this->gallery();
	}

	private function likeComment() {
		$this->_json = json_decode($this->_json, TRUE);
		$this->_userManager = new UserRepository;
		$this->_user = ($this->_userManager->getUserById($_SESSION['logged']))[0];
		if (isset($this->_json['like'])) {
			$this->_user->likeImage($this->_json);
			$this->_imageManager = new ImageRepository;
			$image = $this->_imageManager->getImageById($this->_json['imageId'])[0];
			echo json_encode(array('like' => 1, 'likes' => $image->likes()));
		}
		else if (isset($this->_json['comment'])) {
			$this->_user->postComment($this->_json);
		}
	}

	private function gallery() {
		$this->_imageManager = new ImageRepository;
		$images = $this->_imageManager->getImagesByPublicationDate();
		$this->_view = new View('Accueil');
		$this->_view->generate(array('images' => $images));
	}

}

?>
