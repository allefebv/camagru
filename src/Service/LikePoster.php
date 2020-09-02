<?php

namespace Camagru\Service;

use Camagru\Model\Repositories\LikeRepository;
use Camagru\Model\Entities\Like;

class LikePoster {

    private $likeRepository;

    public function __construct()
    {
        $this->likeRepository = new LikeRepository;
    }

    public function likeImage($imageId, $user)
	{
		$pair = ['userId' => $user->id(), 'imageId' => $imageId];
		if ($this->likeRepository->likeStatus($pair) === 1) {
			$this->likeRepository->delete(new Like($pair));
		} else {
			$this->likeRepository->add(new Like($pair));
		}
	}

}