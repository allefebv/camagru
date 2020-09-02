<?php

namespace Camagru\Service;

use Camagru\Model\Entities\User;
use Camagru\Model\Repositories\CommentRepository;
use Camagru\Model\Repositories\ImageRepository;
use Camagru\Model\Repositories\UserRepository;
use Camagru\Model\Entities\Comment;
use Camagru\Service\Emailer;

class CommentPoster {

    private $user;
    private $commentRepository;
    private $commentData;
    private $lastComment;
    private $emailer;
    private $imageRepository;
    private $userRepository;

    public function __construct(
        User $user,
        CommentRepository $repository,
        array $commentData
    ) {
        $this->user = $user;
        $this->commentRepository = $repository;
        $this->commentData = $commentData;
        $this->emailer = new Emailer();
        $this->imageRepository = new ImageRepository();
        $this->userRepository = new UserRepository();
    }

    public function postComment()
	{
        $comment = new Comment(array(
            'commentText' => $this->commentData['comment'],
            'imageId' => $this->commentData['imageId'],
            'userId' => $this->user->id()
        ));

        try {
            $this->commentRepository->add($comment);
            $this->sendEmailToImageAuthor();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }

        return [
            'success' => 'comment has been posted',
            'comment' => $comment->expose(),
            'commentText' => $comment->commentText(),
            'author' => $this->user->username()
        ];
    }

    private function sendEmailToImageAuthor()
    {
        $image = $this->imageRepository->getImageById($this->commentData['imageId'])[0];
        $imageAuthor = $this->userRepository->getUserById($image->userId())[0];
        if ($imageAuthor->id() !== $this->user->id() && $imageAuthor->notifications()) {
            $this->emailer->setEmailTemplate('NewComment');
            $this->emailer->generateEmail(array('user' => $imageAuthor));
            $this->emailer->setRecipient($imageAuthor->email());
            $this->emailer->send();
        }
    }
}