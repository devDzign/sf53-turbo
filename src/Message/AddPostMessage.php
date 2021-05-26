<?php


namespace App\Message;


use App\Entity\Post;

class AddPostMessage
{
    private Post $post;


    /**
     * AddPostMessage constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

}