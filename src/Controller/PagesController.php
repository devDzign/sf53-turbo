<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PagesController extends AbstractController
{
    #[Route('/pages', name: 'pages')]
    public function index(): Response
    {
        return $this->render(
            'pages/home.html.twig',
            [
                'controller_name' => 'PagesController',
            ]
        );
    }

    #[Route('/pages/about', name: 'about')]
    public function about(): Response
    {
        return $this->render(
            'pages/about.html.twig',
            [
                'controller_name' => 'PagesController',
            ]
        );
    }

}

