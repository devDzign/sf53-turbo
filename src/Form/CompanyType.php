<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Company;
use App\Entity\LegalCategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('siren', TextType::class)
            ->add('cityOfRegistration', TextType::class)
            ->add('capital', NumberType::class, [
                'html5' => true,
            ])
            ->add('legalCategory', EntityType::class, [
                'class' => LegalCategories::class,
                'choice_label' => 'wording',
            ])
//            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
//                $form = $event->getForm();
//                /** @var Company $company */
//                $company = $event->getData();
//
//                if ($company->getLocalizations()->count() === 0) {
//                   $form->add("localizations", CollectionType::class, [
//                       "by_reference" => false,
//                       "allow_add" => true,
//                       "entry_type" => AddressType::class,
//                        "entry_options" => ["label" => false],
//                   ]);
//                }
//            });

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
