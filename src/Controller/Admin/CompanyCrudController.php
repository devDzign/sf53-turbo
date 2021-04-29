<?php

namespace App\Controller\Admin;


use App\Controller\PagesController;
use App\Entity\Company;
use App\Form\AddressType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;


class CompanyCrudController extends AbstractCrudController
{
    private AdminUrlGenerator $adminUrlGenerator;

    /**
     * CompanyCrudController constructor.
     *
     * @param AdminUrlGenerator $adminUrlGenerator
     */
    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }


    public static function getEntityFqcn(): string
    {
        return Company::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('name'),
            FormField::addPanel('company Details'),
            TextField::new('siren'),
            TextField::new('cityOfRegistration'),
            DateTimeField::new('dateOfRegistration')
            ->onlyOnDetail(),
            MoneyField::new('capital')
                ->setCurrency('EUR'),
            AssociationField::new('legalCategory'),
            FormField::addPanel('company Addresses')
                ->onlyWhenCreating(),
            CollectionField::new('localizations')
                ->setFormTypeOptions(
                    [
                        'delete_empty' => true,
                        'by_reference' => false,
                    ]
                )
                ->setCustomOptions(
                    [
                        'allowAdd'       => true,
                        'allowDelete'    => true,
                        'entryType'      => AddressType::class,
                        'showEntryLabel' => false,
                    ]
                )->setRequired(true)
                ->onlyWhenCreating(),


        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name');
    }


    public function configureActions(Actions $actions): Actions
    {

//        $viewInvoice = Action::new('View Invoice', 'test','fas fa-file-invoice')
//            ->linkToRoute('company_index')
//           ;
        return $actions
//            ->add(Crud::PAGE_INDEX, $viewInvoice)
            ->update(
                Crud::PAGE_INDEX,
                Action::EDIT,
                function (Action $action) {
                    return $action
                        ->setIcon('fa fa-pen')
                        ->setLabel(false)
                        ->setCssClass('btn btn-outline-dark mt-2')
                        ;
                }
            )
            ->update(
                Crud::PAGE_INDEX,
                Action::DELETE,
                function (Action $action) {
                    return $action
                        ->setIcon('fa fa-trash')
                        ->setLabel(false)
                        ->setCssClass('btn btn-outline-danger mt-2')
                        ;
                }
            )
            ->add(
                Crud::PAGE_INDEX,
                Action::DETAIL
            )
            ->update(
                Crud::PAGE_INDEX,
                Action::DETAIL,
                fn (Action $action) => $action
                        ->setIcon('fa fa-eye')
                        ->setLabel(false)
                        ->setCssClass('btn btn-outline-success')
            )
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setPaginatorPageSize(3)
            ->showEntityActionsAsDropdown()
            ;
//        return parent::configureCrud($crud);
    }


    // preparation de entity avec des valeurs pre-remplie
//    public function createEntity(string $entityFqcn)
//    {
//        $product = new Company();
//        $product->setName('tttttttt');
//
//        return $product;
//    }

}
