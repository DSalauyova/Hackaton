<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\Constraints\GitHubConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use App\EventListener\UserFormSubscriber;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventSubscriber(new UserFormSubscriber());
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => 2,
                        'maxlength' => 80,
                    ],
                    'label' => 'Login :',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        new Assert\Length(min: 2, max: 80),
                        new Assert\NotBlank()
                    ]
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => 5,
                        'maxlength' => 100,
                    ],
                    'label' => 'Email :',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        new Assert\Length(min: 5, max: 100),
                        new Assert\NotBlank()
                    ]
                ]
            )

            // ->add(
            //     'link_hub',
            //     TextType::class,
            //     [
            //         'mapped' => false,
            //         'attr' => [
            //             'class' => 'form-control',
            //             'minlength' => 5,
            //             'maxlength' => 100,
            //         ],
            //         'label' => 'Link Git',
            //         'label_attr' => [
            //             'class' => 'form-label mt-4'
            //         ],

            //         'constraints' => [
            //             new Assert\Length(['min' => 5, 'max' => 100]),
            //             new Assert\NotBlank(),
            //         ],
            //     ]
            // )


            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    'mapped' => false,
                    'attr' => [
                        'class' => 'form-control',
                        'min' => 5,
                        'max' => 100,
                    ],
                    'label' => 'Password :',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 8, 'max' => 4096]),
                        new Assert\Regex([
                            'pattern' => '/[A-Z]/',
                            'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule.'
                        ]),
                        new Assert\Regex(
                            pattern: '/[a-z]/',
                            message: 'Votre mot de passe doit contenir au moins une lettre minuscule.'
                        ),
                        new Assert\Regex(
                            pattern: '/[0-9]/',
                            message: 'Votre mot de passe doit contenir au moins un chiffre.'
                        ),
                        new Assert\Regex(
                            pattern: '/[\W]/',
                            message: 'Votre mot de passe doit contenir au moins un caractère spécial.'
                        )
                    ]
                ]
            )
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-info mt-5'
                ],
                'label' => 'S\'inscrire'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]
        ]);
    }
}
