<?php


namespace App\Controller\Api;


use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;

class CompanyCountController
{
    private CompanyRepository $companyRepository;

    /**
     * CompanyCountController constructor.
     *
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(Request $request): int
    {
        $isPublished = $request->get("isPublished");
        $conditions = (in_array($isPublished, ['0', '1'], true)) ? ["isPublished" => (($isPublished === '1') ?? false)] : [];

        return $this->companyRepository->count($conditions);
    }
}