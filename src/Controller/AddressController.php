<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Company;
use App\Form\AddressType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company')]
class AddressController extends AbstractController
{

    #[Route('/{id}/new', name: 'address_new', methods: ['GET', 'POST'])]
    public function new(Company $company, Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $address->setCompany($company);
            $entityManager->persist($address);
            $entityManager->flush();

//            return $this->redirectToRoute('address_index', ['id'=> $company->getId()]);
            return $this->redirectToRoute('company_show', ['id' => $company->getId()]);
        }

        return $this->render('address/new.html.twig', [
            'address' => $address,
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/address/{id_address}', name: 'address_show', methods: ['GET'])]
    /**
     * @ParamConverter("address", options={"id" = "id_address"})
     */
    public function show(Company $company, Address $address): Response
    {
        return $this->render('address/show.html.twig', [
            'address' => $address,
            'company' => $company,
        ]);
    }

    #[Route('/{id}/address/{id_address}/edit', name: 'address_edit', methods: ['GET', 'POST'])]
    /**
     * @ParamConverter("address", options={"id" = "id_address"})
     */
    public function edit(Request $request, Company $company, Address $address): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('company_show', ['id' => $company->getId()]);
        }

        return $this->render('address/edit.html.twig', [
            'address' => $address,
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/address/{id_address}', name: 'address_delete', methods: ['POST'])]
    /**
     * @ParamConverter("address", options={"id" = "id_address"})
     */
    public function delete(Request $request, Company $company, Address $address): Response
    {
        if ($this->isCsrfTokenValid('delete' . $address->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($address);
            $entityManager->flush();
        }

        return $this->redirectToRoute('company_show', ['id' => $company->getId()]);
    }
}
