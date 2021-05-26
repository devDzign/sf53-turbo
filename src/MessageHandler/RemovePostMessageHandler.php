<?php


namespace App\MessageHandler;


use App\Message\RemovePostMessage;
use App\Message\SendEmailMessage;
use App\Model\MailModel;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Security;

class RemovePostMessageHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private EntityManagerInterface $entityManager;
    private PostRepository $postRepository;
    private MessageBusInterface $messageBus;
    private Security $security;
    private UserRepository $userRepository;

    /**
     * AddPostMessageHandler constructor.
     *
     * @param MessageBusInterface    $messageBus
     * @param EntityManagerInterface $entityManager
     * @param PostRepository         $postRepository
     * @param Security               $security
     */
    public function __construct(
        MessageBusInterface $messageBus,
        EntityManagerInterface $entityManager,
        PostRepository $postRepository,
        UserRepository $userRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->messageBus = $messageBus;
        $this->userRepository = $userRepository;
    }

    /**
     * @param RemovePostMessage $addPostMessage
     */
    public function __invoke(RemovePostMessage $removePostMessage)
    {
        $post = $this->postRepository->find($removePostMessage->getPostId());
        $user = $this->userRepository->find($removePostMessage->getUserId());

        if (!$post) {
            // could throw an exception... it would be retried
            // or return and this message will be discarded
            if ($this->logger) {
                $this->logger->alert(sprintf('The post %d was missing!', $removePostMessage->getPostId()));
            }
            return;
        }
        $this->entityManager->remove($post);
        $this->entityManager->flush();


        $this->messageBus->dispatch(new SendEmailMessage($user, MailModel::create(
            'Remove Post',
            "Romove Post {$removePostMessage->getPostId()} by user {$user->getId()}",
            'Je teste envoie de mail en async'
        )));
    }
}