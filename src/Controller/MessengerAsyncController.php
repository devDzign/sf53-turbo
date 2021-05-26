<?php

namespace App\Controller;


use App\Message\SendEmailMessage;
use App\Model\MailModel;
use App\Services\EmailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/messenger')]
class MessengerAsyncController extends AbstractController
{

    private EmailSender $emailSender;

    public function __construct(EmailSender $emailSender)
    {
        $this->emailSender = $emailSender;
    }

    #[Route('/step1', name: 'messenger_async_step1')]
    public function step1(): Response
    {
        $this->emailSender->send(
            $this->getUser(),
            MailModel::create(
                'test async messenger',
                'mail en async',
                'Je teste envoie de mail en async'
            )
        );

        return $this->render(
            'messenger_async/index.html.twig',
            [
                'controller_name' => 'step 1',
            ]
        );
    }

    #[Route('/step2', name: 'messenger_async_step2')]
    public function step2(): Response
    {
        $this->dispatchMessage(
            new SendEmailMessage(
                $this->getUser(),
                MailModel::create(
                    'test async messenger',
                    'mail en async',
                    'Je teste envoie de mail en async'
                )
            )
        );


        return $this->render(
            'messenger_async/index.html.twig',
            [
                'controller_name' => 'step 1',
            ]
        );
    }
}
