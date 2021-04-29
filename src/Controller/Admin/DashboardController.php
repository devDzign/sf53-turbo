<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Repository\ArchiveRepository;
use App\Repository\CompanyRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DashboardController extends AbstractDashboardController
{
    private CompanyRepository $companyRepository;
    private ArchiveRepository $archiveRepository;
    private ChartBuilderInterface $chartBuilder;

    /**
     * DashboardController constructor.
     *
     * @param CompanyRepository     $companyRepository
     * @param ArchiveRepository     $archiveRepository
     * @param ChartBuilderInterface $chartBuilder
     */
    public function __construct(
        CompanyRepository $companyRepository,
        ArchiveRepository $archiveRepository,
        ChartBuilderInterface $chartBuilder
    ) {
        $this->companyRepository = $companyRepository;
        $this->archiveRepository = $archiveRepository;
        $this->chartBuilder      = $chartBuilder;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $datasArchived = $this->archiveRepository->getData();

        $labels = [];
        $datas = [];
        foreach ($datasArchived as $data) {
            $labels[] = $data["name"].'-'.$data['objectId'];
            $datas[]  = $data['nb'];
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData(
            [
                'labels'   => $labels,
                'datasets' => [
                    [
                        'label'           => 'Archive for companies',
                        'backgroundColor' => 'rgb(255, 99, 132)',
                        'borderColor'     => 'rgb(255, 99, 132)',
                        'data'            => $datas,
                    ],
                ],
            ]
        );

        $chart->setOptions(
            [
                'scales' => [
                    'yAxes' => [
                        ['ticks' => ['min' => 0]],
                    ],
                ],
            ]
        );


        return $this->render(
            'admin/index.html.twig',
            [
                'companiesCount' => $this->companyRepository->count([]),
                'archivedCount'  => $this->archiveRepository->count([]),
                'chart'          => $chart,
            ]
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sf53 Turbo');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setPaginatorPageSize(2);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Companies', 'fas fa-building');
        yield MenuItem::linkToCrud('Company', 'fas fa-list', Company::class);
    }
}
