<?php


namespace App\Message;


use App\Entity\Post;
use App\Entity\User;

class RemovePostMessage
{
    private int $postId;
    private int $userId;


    /**
     * RemovePostMessage constructor.
     *
     * @param int $postId
     * @param int $userId
     */
    public function __construct(int $postId, int $userId)
    {
        $this->postId = $postId;
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }


}