<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company')]
class CompanyController extends AbstractController
{
    #[Route('/', name: 'company_index', methods: ['GET'])]
    public function index(
        CompanyRepository $companyRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $className = Company::class;
        $dql       = "SELECT a FROM App\Entity\Company a";
        $query     = $this->getDoctrine()->getManager()->createQuery($dql);
        $companies = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            1
        );

        return $this->render(
            'company/index.html.twig',
            [
                'companies' => $companies,
            ]
        );
    }

    #[Route('/new', name: 'company_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request
    ): Response {
        $company = new Company();
        $form    = $this->createForm(CompanyType::class, $company);
//        $form->handleRequest($request);


        return $this->handleForm(
            $form,
            $request,
            function () {
                $this->addFlash('success', 'message envoyé 🥇 🔋');
                return $this->redirectToRoute('company_index');
            },
            function (FormInterface $form, $data) {
                return $this->render('company/new.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        );

//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//
//            $entityManager->persist($company);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('company_index');
//        }

//        return $this->render(
//            'company/new.html.twig',
//            [
//                'company' => $company,
//                'form'    => $form->createView(),
//            ]
//        );
    }

    #[Route('/{id}', name: 'company_show', methods: ['GET'])]
    public function show(
        Company $company
    ): Response {
        return $this->render(
            'company/show.html.twig',
            [
                'company' => $company,
            ]
        );
    }

    #[Route('/{id}/edit', name: 'company_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Company $company
    ): Response {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('company_show', ['id' => $company->getId()]);
        }

        return $this->render(
            'company/edit.html.twig',
            [
                'company' => $company,
                'form'    => $form->createView(),
            ]
        );
    }

    #[Route('/{id}', name: 'company_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Company $company
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return $this->redirectToRoute('company_index');
    }
}
