<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function index(AdminContext $context)
    {
        return parent::index($context);
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name')
            ->setTemplatePath('admin/fields/slug.html.twig')
            ,
            SlugField::new('slug')->setTargetFieldName('name')->hideOnIndex(),
            TextEditorField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),
        ];

        $fields[] = match ($pageName) {
            Crud::PAGE_INDEX, Crud::PAGE_DETAIL => ImageField::new('image')->setBasePath('/uploads/images/products/'),
            default => TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
        };

        return $fields;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Produits')
            // set this option if you prefer the page content to span the entire
            // browser width, instead of the default design which sets a max width
//            ->renderContentMaximized()

            // set this option if you prefer the sidebar (which contains the main menu)
            // to be displayed as a narrow column instead of the default expanded design
//            ->renderSidebarMinimized()
            ;
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {

        $queryBuilder =  parent::createIndexQueryBuilder(
            $searchDto,
            $entityDto,
            $fields,
            $filters
        );

        //Faire une requete personaliser

//        dd($queryBuilder->getAllAliases());
//        return  $queryBuilder->where('entity.user =:user')
//            ->setParameter('user', $this->getUser());

        return $queryBuilder;
    }


    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        if (Crud::PAGE_INDEX === $responseParameters->get('pageName')) {
            $responseParameters->set('foo', 'test value');
        }

        return $responseParameters;
    }


    public function configureActions(Actions $actions): Actions
    {

        $adminAction = Action::new('adminer', 'admin Dashboard', 'fa fa-trash')
        ->addCssClass('btn btn-warning')
            ->linkToUrl(
                'adminer',
                function ($entity) {
                    dd($entity);
                    return [
                        'test' => $entity
                    ];
                }
            )
        ;

        $linkExterne = Action::new('externeGitHub', 'Github', 'fab fa-github')
            ->linkToUrl('https://github.com')
            ->setHtmlAttributes([
                'target' => '_blank'
                                ])
            ->addCssClass('btn btn-success text-dark mt-2');

        return $actions
            ->add(Crud::PAGE_INDEX, $linkExterne)
            ->add(Crud::PAGE_INDEX, $adminAction)
            ->update(
                Crud::PAGE_INDEX,
                Action::EDIT,
                function (Action $action) {
                    return $action
                        ->setIcon('fa fa-pen')
                        ->setLabel(false)
                        ->setCssClass('btn btn-outline-dark mt-2');
                }
            )
            ->update(
                Crud::PAGE_INDEX,
                Action::DELETE,
                function (Action $action) {
                    return $action
                        ->setIcon('fa fa-trash')
                        ->setLabel(false)
                        ->setCssClass('btn btn-outline-danger mt-2');
                }
            )
            ->add(
                Crud::PAGE_INDEX,
                Action::DETAIL
            )
            ->update(
                Crud::PAGE_INDEX,
                Action::DETAIL,
                fn(Action $action) => $action
                    ->setIcon('fa fa-eye')
                    ->setLabel(false)
                    ->setCssClass('btn btn-outline-success mt-2')
            );
    }
}
