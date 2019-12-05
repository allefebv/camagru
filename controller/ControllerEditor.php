<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');

class ControllerEditor {

	private $_view;
	private $_imageManager;
	private $_post;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (!isset($_SESSION['logged']))
			throw new Exception('Section Autorisée aux utilisateurs connectés');
		else if ($this->_post = file_get_contents('php://input'))
		// else if (isset($_POST['img']))
			$this->saveImg();
		$this->editor();
	}

	private function editor() {
		$this->_view = new View('Editor');
		$this->_view->generate(array());
	}

	private function saveImg() {
		$this->_imageManager = new ImageManager;
		$imgUrl = json_decode($this->_post, TRUE);
		$imgUrl = explode(',', $imgUrl['img']);
		$imgUrl = base64_decode($imgUrl[1]);
		$imgId = (int)current($this->_imageManager->getBiggestId()) + 1;
		$imgName = 'image_' . $imgId . '.png';
		$imgPath = '/public/userImages/'.$imgName;
		$img = new Image(array('pathToImage' => $imgPath));
		// $img = new Image(array('pathToImage' => $imgUrl));
		$this->_imageManager->add($img);
		file_put_contents($_SERVER['DOCUMENT_ROOT'].$imgPath, $imgUrl);
		// file_put_contents($_SERVER['DOCUMENT_ROOT'].$imgPath, $this->_post);
	}

	//Page d'accueil = header (connexion etc) + gallerie + footer

}

?>
