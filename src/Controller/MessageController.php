<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageController extends AbstractController
{



    #[Route('/pages/contact', name: 'contact')]
    public function contact(
        Request $request
    ): Response {



        $form = $this->createFormBuilder()
            ->add(
                'name',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 2]),
                    ],
                    'attr'        => ['placeholder' => 'Ex: John Doe'],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Email(),
                    ],
                    'attr'        => ['placeholder' => 'Ex: example@email.fr'],
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 10]),
                    ],
                    'attr'        => ['placeholder' => 'Ex: Please enter your message here...'],
                ]
            )
            ->getForm();


        return $this->handleForm(
            $form,
            $request,
            function () {
                $this->addFlash('success', 'message envoyé 🥇');
                return $this->redirectToRoute('pages');
            },
            function (FormInterface $form, $data) {
                return $this->render('pages/contact.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        );
    }
}
