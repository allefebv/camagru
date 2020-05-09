<?php

namespace Camagru\Model\Repositories;

use Camagru\Model\Entities\Image;

require("config/database.php");

class ImageRepository extends BaseRepository {

	public function getImages() {
		return $this->getAll('image', Image::class);
	}

	public function getImagesByPublicationDate() {
		return $this->getAllOrderByKeyDesc('image', Image::class, 'publicationDate');
	}

	public function getImageById($id) {
		return $this->getByKey('image', Image::class, 'id', $id);
	}

	public function add(Image $image) {
		$req = $this->getDb()->prepare('INSERT INTO image(pathToImage, userId) VALUES(:pathToImage, :userId)');
		$req->execute(array('pathToImage' => $image->pathToImage(), 'userId' => $image->userId()));
	}

	public function delete(Image $image) {

	}

	public function update(Image $image) {

	}

	public function getBiggestId() {
		$req = $this->getDb()->prepare('SELECT MAX(id) FROM `image`');
		$req->execute();
		return $req->fetch();
	}
}

?>
