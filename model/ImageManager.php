<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class ImageManager extends Model {

	//table DB 'image' et classe 'Image'
	public function getImages() {
		return $this->getAll('image', 'Image');
	}

	public function add(Image $image) {
		$req = $this->getDb()->prepare('INSERT INTO image(pathToImage) VALUES(:pathToImage)');
		$req->execute(array('pathToImage' => $image->pathToImage()));
	}

	public function delete(Image $image) {

	}

	public function update(Image $image) {

	}
}

?>
