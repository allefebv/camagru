<?php

namespace Camagru\Controller;

use Camagru\Model\Repositories\ImageRepository;
use Camagru\Model\Repositories\UserRepository;
use Camagru\Model\Repositories\CommentRepository;
use Camagru\Model\Repositories\LikeRepository;
use Camagru\Service\ViewGenerator;
use Camagru\Service\CommentPoster;
use Camagru\Service\LikePoster;
use \Exception;

class ControllerAccueil {

	private $imageRepository;
	private $userRepository;
	private $commentRepository;
	private $user;
	private $image;
	private $viewGenerator;
	private $commentPoster;
	private $likePoster;
	private $json;

	public function __construct($url)
	{
		$this->commentRepository = new CommentRepository;
		$this->userRepository = new UserRepository;
		$this->imageRepository = new ImageRepository;
		
		if (((is_array($url) || $url instanceof countable)
			&& count($url)) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if ($this->json = file_get_contents('php://input'))
			$this->actionDispatch();
		else
			$this->gallery();
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
			$this->likeComment();
		} else if (isset($this->json['getImages'])) {
			$this->sendImages();
		} else if (isset($this->json['getImageDetails'])) {
			$this->getImageDetails();
		} else if (isset($this->json['comment'])) {
			$this->postComment();
		} else if (isset($this->json['getImageComments'])) {
			$this->getImageComments();
		} else if (isset($this->json['connexionStatus'])) {
			$this->islogged();
		}
	}

	private function likeComment()
	{
		$this->user = ($this->userRepository->getUserById($_SESSION['logged']))[0];
		if (isset($this->json['like'])) {
			$this->user->likeImage($this->json);
			$image = $this->imageRepository->getImageById($this->json['imageId'])[0];
			echo json_encode(array('like' => 1, 'likes' => $image->likes(), 'imageId' => $this->json['imageId']));
		}
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

	private function sendImages()
	{
		$images = $this->imageRepository->getAllImagesByPublicationDate();
		echo json_encode($this->imageRepository->getExposedImages($images));
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
		$this->image = $image = $this->imageRepository->getImageById($this->json['imageId'])[0];
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
		if ($_SESSION['logged']) {
			$reponse = ['logged' => true];
		} else {
			$response = ['logged' => false];
		}
		echo json_encode($response);
	}

}

?>
