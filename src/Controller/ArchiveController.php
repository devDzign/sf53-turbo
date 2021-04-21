<?php

namespace App\Controller;

use App\Entity\Archive;
use App\Entity\Company;
use App\Repository\ArchiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/company')]
class ArchiveController extends AbstractController
{
    #[Route('/{id}/archive', name: 'archive')]
    public function index(Company $company, ArchiveRepository $archiveRepository): Response
    {
        return $this->render("archive/index.html.twig", [
           "companyOrigin" => $company,
           "archives" => $archiveRepository->findAllArchivesForCompany(Company::class, $company->getId())
        ]);
    }

    #[Route('/{id}/archive/{id_archive}', name: 'detail_archive')]
    /**
     * @ParamConverter("archive", options={"id" = "id_archive"})
     */
    public function details(Company $company, Archive $archive): Response
    {
        return $this->render("archive/detail.html.twig", [
            "companyOrigin" => $company,
            "archive" => $archive
        ]);
    }
}
