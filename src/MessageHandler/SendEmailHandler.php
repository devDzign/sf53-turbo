<?php


namespace App\MessageHandler;


use App\Message\SendEmailMessage;
use App\Services\EmailSender;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendEmailHandler implements MessageHandlerInterface
{
    private EmailSender $emailSender;

    public function __construct(EmailSender $emailSender)
    {
        $this->emailSender = $emailSender;
    }

    public function __invoke(SendEmailMessage $sendEmailMessage)
    {
        $this->emailSender->send($sendEmailMessage->getUser(), $sendEmailMessage->getMailModel());
    }
}