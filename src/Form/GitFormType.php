<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\GitLink;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class GitFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'url',
                UrlType::class,
                [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Lien Git :',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        //contrainte personnalisée vérifie si l'URL commence par les chaînes requises
                        new Callback([$this, 'validateUrl']),

                    ]

                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-info mt-5'
                    ],
                    'label' => 'Generer un Rapport'
                ]
            );
    }

    public function validateUrl($url, ExecutionContextInterface $context): void
    {
        if (!preg_match('/^(https?:\/\/)?(github\.com|gitlab\.com)/', $url)) {
            $context->buildViolation('Vous devez saisir un URL "github" ou "gitlab" valable !')
                ->addViolation();
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GitLink::class,
        ]);
    }
}
