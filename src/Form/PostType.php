<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'help'=> 'titre de post'
                ]
            )
            ->add(
                'content',
                TextareaType::class,
                [
                    'attr' => [
                        'autocomplete' => 'new-password'
                    ],

                    'constraints' => [
                        new NotBlank([
                                         'message' => 'Please enter a cotent',
                                     ]),
                        new Length([
                                       'min' => 6,
                                       'minMessage' => 'Your password should be at least {{ limit }} ',
                                       // max length allowed by Symfony for security reasons
                                       'max' => 4096,
                                   ]),
                    ],
                    'label' => 'Content text',
                ]
            )
//            ->add(
//                'createdAt',
//                null,
//                [
//                    'widget' => 'single_text'
//                ]
//            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
