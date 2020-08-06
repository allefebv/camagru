<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\LayerRepository;
use Camagru\Model\Repositories\ImageRepository;
use Camagru\Model\Entities\Image;
use Camagru\Service\ViewGenerator;
use \Exception;

class ControllerEditor {

	private $_viewGenerator;
	private $_imageRepository;
	private $_layerRepository;
	private $_json;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (!isset($_SESSION['logged']))
			throw new Exception('Section Autorisée aux utilisateurs connectés');
		else if ($this->_json = file_get_contents('php://input'))
			$this->saveImg();
		$this->editor();
	}

	private function editor() {
		$this->_layerRepository = new LayerRepository;
		$this->_viewGenerator = new ViewGenerator('Editor');
		$this->_viewGenerator->generate(array('layers' => $this->_layerRepository->getLayers()));
	}

	private function saveImg() {
		$this->_imageRepository = new ImageRepository;
		$this->_json = \json_decode($this->_json, TRUE);

		$imgUrl = explode(',', $this->_json['img']);

		$imgUrl = base64_decode($imgUrl[1]);
		$imgId = (int)current($this->_imageRepository->getBiggestId()) + 1;
		$imgName = 'image_' . $imgId . '.png';
		$imgPath = '/data/userImages/'.$imgName;
		$img = new Image(array('pathToImage' => $imgPath, 'userId' => $_SESSION['logged']));
		$this->_imageRepository->add($img);
		file_put_contents($_SERVER['DOCUMENT_ROOT'].$imgPath, $imgUrl);


		$layerRepository = new LayerRepository;
		$layer = ($layerRepository->getLayerById($this->_json['layer']))[0];
		$layerPath = $layer->pathToLayer();

		$userImage = \imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$imgPath);
		$layerImage = \imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$layerPath);
		$layerWidth = imagesx($layerImage);
		$layerHeight = imagesy($layerImage);
		imagealphablending($userImage, true);
		imagesavealpha($userImage, true);
		imagecopyresampled($userImage, $layerImage, 0, 0, 0, 0, 320, 240, $layerWidth, $layerHeight);
		imagepng($userImage, $_SERVER['DOCUMENT_ROOT'].$imgPath);
	}

	//Page d'accueil = header (connexion etc) + gallerie + footer

}

?>
