<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\ArchiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search/{id}/archive', name: 'search_archive')]
    public function index(
        Company $company,
        ArchiveRepository $archiveRepository
    ): Response {
        return $this->render(
            'stimulus/index.html.twig',
            [
                'companyId' => $company->getId(),
                'archives'  => $archiveRepository->findAllArchivesForCompany(Company::class, $company->getId()),
            ]
        );
    }

    #[Route('/api/search/{id}/archive/{dateSearch}/exact', name: 'api.search_archive_exact')]
    public function exactDate(
        Company $company,
        $dateSearch,
        ArchiveRepository $archiveRepository
    ): Response {

        return $this->json(
            [
                "data" => [
                    "archives" => $archiveRepository
                        ->findOneArchiveByData(
                            Company::class,
                            $company->getId(),
                            new \DateTime(date('Y-m-d H:i:s', strtotime($dateSearch)))
                        ),
                ],
            ]
        );
    }

    #[Route('/api/search/{id}/archive/{dateSearch}', name: 'api.search_archive')]
    public function search(
        Company $company,
        $dateSearch,
        ArchiveRepository $archiveRepository
    ): JsonResponse {
        return $this->json(
            [
                "data" => [
                    "archives" => $archiveRepository
                        ->findAllArchivesWithDate(
                            Company::class,
                            $company->getId(),
                            new \DateTime(date('Y-m-d H:i:s', strtotime($dateSearch)))
                        ),
                ],
            ]
        );
    }
}
