<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'Enter Email'],
                'constraints' => [
                    new NotBlank([
                                     'message' => 'Please enter a email',
                                 ]),
                    new Email(),
                ],
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['placeholder' => 'Enter firstname'],
                'constraints' => [
                    new NotBlank([
                                     'message' => 'Please enter a firstname',
                                 ])
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['placeholder' => 'Enter lastname'],
                'constraints' => [
                    new NotBlank([
                                     'message' => 'Please enter a lastname',
                                 ])
                ],
            ])
            ->add('username', TextType::class, [
                'attr' => ['placeholder' => 'Enter username'],
                'constraints' => [
                    new NotBlank([
                                     'message' => 'Please enter a lastname',
                                 ]),
                    new Length([
                                   'min' => 6,
                                   'minMessage' => 'Your username should be at least {{ limit }} characters',
                                   'max' => 10,
                               ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type'=> PasswordType::class,
                'options' => ['attr' => ['class' => 'password-field', 'placeholder' => 'Your password']],
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeated Password'],
                'invalid_message' => 'The password fields must match.',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                                     'message' => 'Please enter a password',
                                 ]),
                    new Length([
                                   'min' => 6,
                                   'minMessage' => 'Your password should be at least {{ limit }} characters',
                                   // max length allowed by Symfony for security reasons
                                   'max' => 4096,
                               ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
