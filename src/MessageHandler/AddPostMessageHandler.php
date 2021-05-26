<?php


namespace App\MessageHandler;


use App\Message\AddPostMessage;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddPostMessageHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private PostRepository $postRepository;

    /**
     * AddPostMessageHandler constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param PostRepository         $postRepository
     */
    public function __construct(EntityManagerInterface $entityManager, PostRepository $postRepository)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
    }

    /**
     * @param AddPostMessage $addPostMessage
     */
    public function __invoke(AddPostMessage $addPostMessage)
    {
        $this->entityManager->persist($addPostMessage->getPost());
        $this->entityManager->flush();
    }
}