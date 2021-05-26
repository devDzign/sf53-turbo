<?php


namespace App\Message;


use App\Entity\User;
use App\Model\MailModel;

class SendEmailMessage
{
    public User $user;
    public MailModel $mailModel;


    public function __construct(User $user, MailModel $mailModel)
    {
        $this->user = $user;
        $this->mailModel = $mailModel;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return MailModel
     */
    public function getMailModel(): MailModel
    {
        return $this->mailModel;
    }



}