<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\ImageRepository;
use Camagru\Model\Repositories\UserRepository;
use Camagru\Model\Repositories\CommentRepository;
use Camagru\Model\Repositories\LikeRepository;
use Camagru\Service\ViewGenerator;
use Camagru\Service\CommentPoster;
use Camagru\Service\LikeService;
use \Exception;

class ControllerAccueil {

	private $imageRepository;
	private $userRepository;
	private $commentRepository;
	private $user;
	private $image;
	private $viewGenerator;
	private $commentPoster;
	private $likeService;
	private $json;

	public function __construct($url)
	{
		$this->commentRepository = new CommentRepository;
		$this->userRepository = new UserRepository;
		$this->imageRepository = new ImageRepository;
		$this->likeService = new LikeService;
		
		if (((is_array($url) || $url instanceof countable)
			&& count($url)) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if ($this->json = file_get_contents('php://input')) {
			$this->actionDispatch();
		} else {
			$this->gallery();
		}
	}

	private function gallery()
	{
		$this->viewGenerator = new ViewGenerator('Accueil');
		$this->viewGenerator->generate();
	}

	private function actionDispatch()
	{
		$this->json = json_decode($this->json, TRUE);

		if (isset($this->json['like'])) {
			$this->likeImage();
		} else if (isset($this->json['getAllImages'])) {
			$this->sendAllImages();
		} else if (isset($this->json['getOwnImages'])) {
			$this->sendOwnImages();
		} else if (isset($this->json['getImageDetails'])) {
			$this->getImageDetails();
		} else if (isset($this->json['comment'])) {
			$this->postComment();
		} else if (isset($this->json['getImageComments'])) {
			$this->getImageComments();
		} else if (isset($this->json['connexionStatus'])) {
			$this->islogged();
		} else if (isset($this->json['deleteImage'])) {
			$this->deleteImage();
		} else if (isset($this->json['hasUserLikedImage'])) {
			$this->hasUserLikedImage();
		}
	}

	private function deleteImage() {
		$this->imageRepository = new ImageRepository;
		$image = $this->imageRepository->getImageById($this->json['deleteImage'])[0];
		$this->imageRepository->delete($image);
		header('Content-Type: application/json');
		echo json_encode(array('id' => $image->id()));
	}

	private function likeImage()
	{
		$this->user = ($this->userRepository->getUserById($_SESSION['logged']))[0];
		if (isset($this->json['like'])) {
			$action = $this->likeService->likeImage($this->json['imageId'], $this->user);
			$image = $this->imageRepository->getImageById($this->json['imageId'])[0];
			echo json_encode(array('like' => 1, 'likes' => $image->likes(), 'imageId' => $this->json['imageId'], 'action' => $action));
		}
	}

	private function hasUserLikedImage() {
		$this->user = ($this->userRepository->getUserById($_SESSION['logged']))[0];
		$hasUserLikedImage = $this->likeService->hasUserLikedImage($this->json['imageId'], $this->user);
		header('Content-Type: application/json');
		echo \json_encode(array('like_status' => $hasUserLikedImage));
	}

	private function postComment()
	{
		$this->user = ($this->userRepository->getUserById($_SESSION['logged']))[0];
		$this->commentPoster = new CommentPoster(
			$this->user,
			new CommentRepository,
			$this->json
		);
		echo json_encode($this->commentPoster->postComment());
	}

	private function sendAllImages()
	{
		if ($this->json['lastId']) {
			$images = $this->imageRepository->getSomeImagesByPublicationDateOffset($this->json['nbImages'], $this->json['lastId']);
		} else {
			$images = $this->imageRepository->getSomeImagesByPublicationDate($this->json['nbImages']);
		}

		if ($images) {
			echo json_encode($this->imageRepository->getExposedImages($images));
		} else {
			echo json_encode(array('empty' => 1));
		}
	}

	private function sendOwnImages()
	{
		if ($this->json['lastId']) {
			$images = $this->imageRepository->getSomeImagesFromUserByPublicationDateWithOffset($this->json['nbImages'], $this->json['lastId'], $_SESSION['logged']);
		} else {
			$images = $this->imageRepository->getSomeImagesByPublicationDateUserIs($this->json['nbImages'], $_SESSION['logged']);
		}

		if ($images) {
			echo json_encode($this->imageRepository->getExposedImages($images));
		} else {
			echo json_encode(array('empty' => 1));
		}
	}

	private function getImageDetails()
	{
		$this->image = $image = $this->imageRepository->getImageById($this->json['imageId'])[0];
		echo json_encode(array(
			'imageDetails' => $this->imageRepository->getExposedImage($this->image),
			'imageAuthor' => $this->userRepository->getUserById($this->image->userId())[0]->username(),
			'imageComments' => $this->getImageComments()
		));
	}

	private function getImageComments()
	{
		$this->image = $this->imageRepository->getImageById($this->json['imageId'])[0];
		$comments = $this->commentRepository->getImageCommentsByPublicationDate($this->json['imageId']);
		$exposedComments = $comments ? $this->commentRepository->getExposedComments($comments) : null;
		if ($exposedComments) {
			foreach ($exposedComments as $exposedComment) {
				$complete[] = [
					'comment' => $exposedComment,
					'author' => $this->userRepository->getUserById($exposedComment['_userId'])[0]->username()
				];
			}
			return $complete;
		}
	
		return null;
	}

	private function islogged()
	{
		if (isset($_SESSION['logged']) && $_SESSION['logged']) {
			$response = ['logged' => true];
		} else {
			$response = ['logged' => false];
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

}

?>
