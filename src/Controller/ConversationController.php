<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Participant;
use App\Repository\ConversationRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/conversations')]
class ConversationController extends AbstractController
{

    private ParticipantRepository $participantRepository;
    private EntityManagerInterface $entityManager;
    private ConversationRepository $conversationRepository;

    public function __construct(
        ParticipantRepository $participantRepository,
        EntityManagerInterface $entityManager,
        ConversationRepository $conversationRepository
    ) {
        $this->participantRepository  = $participantRepository;
        $this->entityManager          = $entityManager;
        $this->conversationRepository = $conversationRepository;
    }


    /**
     * @throws \Exception
     */
    #[Route('/', name: 'new.conversation', methods: ['POST'])]
    public function index(
        Request $request
    ): Response {
        $otherUser = $request->get('otherUsers', 0);
        $otherUser = $this->participantRepository->find($otherUser);

        if (is_null($otherUser)) {
            throw new \Exception('The user was not found');
        }

        // cannot create a conversation with myself

        if ($otherUser->getId() === $this->getUser()->getId()) {
            throw new \Exception('Cannot create a conversation with myself');
        }

        // check if conversation already exist
        $conversation = $this->conversationRepository
            ->findConversationByParticipants(
                $otherUser->getId(),
                $this->getUser()->getId()
            );


        if (count($conversation)) {
            throw new \Exception('The conversation already exists');
        }


        $conversation = new Conversation();

        $participant = new Participant();
        $participant
            ->setUser($this->getUser())
            ->setConversation($conversation);

        $participantOther = new Participant();
        $participantOther
            ->setUser($otherUser)
            ->setConversation($conversation);


        $this->entityManager->getConnection()->beginTransaction();
        try {
            $this->entityManager->persist($conversation);
            $this->entityManager->persist($participant);
            $this->entityManager->persist($participantOther);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }


        return $this->json(
            [
                'id' => $conversation->getId(),
            ],
            Response::HTTP_CREATED
        );
    }


    #[Route('/', name: 'get.conversation', methods: ['GET'])]
    /**
     *  @IsGranted("ROLE_ADMIN")
     */
    public function getConv()
    {
//        $this->denyAccessUnlessGranted('ROLE_USER');
        $conversations = $this->conversationRepository
            ->findConversationsByUser($this->getUser()->getId());

        return $this->json($conversations);
    }
}
