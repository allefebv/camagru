<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');

class ControllerEditor {

	private $_view;
	private $_imageManager;
	private $_layerManager;
	private $_json;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (!isset($_SESSION['logged']))
			throw new Exception('Section Autorisée aux utilisateurs connectés');
		else if ($this->_json = file_get_contents('php://input'))
		// else if (isset($_POST['img']))
			$this->saveImg();
		$this->editor();
	}

	private function editor() {
		$this->_layerManager = new LayerManager;
		$this->_view = new View('Editor');
		$this->_view->generate(array('layers' => $this->_layerManager->getLayers()));
	}

	private function saveImg() {
		$this->_imageManager = new ImageManager;
		$this->_json = json_decode($this->_json, TRUE);

		$imgUrl = explode(',', $this->_json['img']);

		$imgUrl = base64_decode($imgUrl[1]);
		$imgId = (int)current($this->_imageManager->getBiggestId()) + 1;
		$imgName = 'image_' . $imgId . '.png';
		$imgPath = '/public/userImages/'.$imgName;
		$img = new Image(array('pathToImage' => $imgPath));
		$this->_imageManager->add($img);
		file_put_contents($_SERVER['DOCUMENT_ROOT'].$imgPath, $imgUrl);


		$layerManager = new LayerManager;
		$layer = $layerManager->getLayerById($this->_json['layer']);
		$layerPath = $layer->pathToLayer();

		$userImage = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$imgPath);
		$layerImage = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$layerPath);
		$layerWidth = imagesx($layerImage);
		$layerHeight = imagesy($layerImage);
		var_dump($_SERVER['DOCUMENT_ROOT'].$layerPath);
		var_dump($_SERVER['DOCUMENT_ROOT'].$imgPath);
		imagealphablending($userImage, true);
		imagesavealpha($userImage, true);
		imagecopyresampled($userImage, $layerImage, 0, 0, 0, 0, 320, 240, $layerWidth, $layerHeight);
		imagepng($userImage, $_SERVER['DOCUMENT_ROOT'].$imgPath);
	}

	//Page d'accueil = header (connexion etc) + gallerie + footer

}

?>
