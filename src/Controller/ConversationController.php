<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/conversation')]
class ConversationController extends AbstractController
{

    private ParticipantRepository $participantRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ParticipantRepository $participantRepository , EntityManagerInterface $entityManager)
    {
        $this->participantRepository = $participantRepository;
        $this->entityManager = $entityManager;
    }


    /**
     * @throws \Exception
     */
    #[Route('/', name: 'getConversation')]
    public function index(Request $request): Response
    {
        $otherUsers =  $request->get('otherUsers', 0);
        $otherUsers = $this->participantRepository->find($otherUsers);

        if(is_null($otherUsers)){
            throw new \Exception('The user was not found');
        }

        //

        return $this->json();
    }
}
