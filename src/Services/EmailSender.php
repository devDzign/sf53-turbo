<?php


namespace App\Services;


use App\Entity\User;
use App\Model\MailModel;
use Mailjet\Client;
use Mailjet\Resources;

class EmailSender implements EmailSenderInterface
{
    public function send(User $user, MailModel $mailModel)
    {
        $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'],true,['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "chabour.mourad87@gmail.com",
                        'Name' => "Mchab Contact"
                    ],
                    'To' => [
                        [
                            'Email' => $user->getEmail(),
                            'Name' => $user->getFirstname().' '.$user->getLastname()
                        ]
                    ],
                    'TemplateID' => 2895426,
                    'TemplateLanguage' => true,
                    'Subject' => $mailModel->getSubject(),
                    'Variables'        => [
                        "mailTitle"   => $mailModel->getTitle(),
                        "mailContent" => $mailModel->getContent()
                    ],
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);

//        $response->success() && dd($response->getData());
    }
}