<?php

namespace Camagru\Model\Repositories;

use Camagru\Model\Entities\Image;

require("config/database.php");

class ImageRepository extends BaseRepository {

	public function getImages() {
		return $this->getAll('image', Image::class);
	}

	public function getSomeImages(int $limit) {
		return $this->getSome('image', Image::class, $limit);
	}

	public function getAllImagesByPublicationDate() {
		return $this->getAllOrderByKeyDesc('image', Image::class, 'publicationDate');
	}

	public function getSomeImagesByPublicationDate(int $limit) {
		return $this->getSomeOrderByKeyDesc('image', Image::class, 'publicationDate', $limit);
	}

	public function getSomeImagesByPublicationDateOffset(int $limit, int $offset) {
		return $this->getSomeOrderByKeyDescOffsetIdInf('image', Image::class, 'publicationDate', $limit, $offset);
	}

	public function getImageById($id) {
		return $this->getByKey('image', Image::class, 'id', $id);
	}

	public function getExposedImages(array $images) {
		return $this->getExposedObjects($images);
	}

	public function getExposedImage($image) {
		return $this->getExposedObject($image);
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
