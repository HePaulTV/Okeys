<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Constraint;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Entity\User;
use App\Entity\Annonce;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder ->add('datetime', DateType::class, [
            'widget' => 'single_text',
            // Utiliser 'constraints' pour appliquer la restriction de date
            'constraints' => [
                new GreaterThanOrEqual([
                    'value' => 'today',
                    'message' => 'La date ne peut pas être antérieure à la date actuelle.',
                ]),
            ],
            // Définir une valeur minimum pour la sélection de la date
            'attr' => [
                'min' => (new \DateTime())->format('Y-m-d'),
            ],
        ])
        ->add('agent', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'nom',
            'attr' => ['class'=> 'form-control'],
            'label_attr' => ['class'=> 'fw-bold'],
            'query_builder' => function (EntityRepository $er) {
                // Cette requête est juste un exemple. Vous devez l'ajuster en fonction de votre implémentation spécifique.
                return $er->createQueryBuilder('u')
                    ->where('u.roles LIKE :roles')
                    ->setParameter('roles', '%ROLE_AGENT%'); // Assurez-vous que le format correspond à celui de votre base de données.
            },
        ])
        ->add('annonce', HiddenType::class, [
            'data' => $options['annonce_id'],
        ])
        ->add('confirmer', SubmitType::class, [
            'attr' => ['class'=> 'btn m-4' ], 
            'row_attr' => ['class' => 'text-center'],
        ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        // Configure your form options here

        'annonce_id' => null,
        ]);
    }
}

