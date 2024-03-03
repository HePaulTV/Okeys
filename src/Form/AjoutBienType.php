<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Type;


class AjoutBienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['class'=> 'form-control'], 
                'label_attr' => ['class'=> 'fw-bold']
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class'=> 'form-control', 'rows'=>'7', 'cols' => '7'], 
                'label_attr' => ['class'=> 'fw-bold']
            ])
            ->add('image', TextType::class, [
                'attr' => ['class'=> 'form-control'], 
                'label_attr' => ['class'=> 'fw-bold']
            ])
            ->add('prix', MoneyType::class, [
                'attr' => ['class'=> 'form-control'], 
                'label_attr' => ['class'=> 'fw-bold']
            ])
            ->add('m2', NumberType::class, [
                'attr' => ['class'=> 'form-control'], 
                'label_attr' => ['class'=> 'fw-bold']
            ])
            ->add('jardin', ChoiceType::class, [
                'choices'  => ['Oui' => 1, 'Non' => 0],
            ])
            ->add('garage', ChoiceType::class, [
                'choices'  => ['Oui' => 1, 'Non' => 0],
            ])
            /*->add('codePostal', TextType::class, [
                'mapped' => false, // Indique que ce champ n'est pas lié à la base de données
                'attr' => ['class' => 'form-control', 'id' => 'ajout_bien_codePostal'],
                'label' => 'Code Postal',
            ])*/
            ->add('commune', TextType::class, [
                'attr' => ['class'=> 'form-control','id' => 'ajout_bien_commune'],
                'label_attr' => ['class'=> 'fw-bold']
            ])
            ->add('departement', TextType::class, [
                'attr' => ['class'=> 'form-control'], 
                'label_attr' => ['class'=> 'fw-bold']
            ])
            ->add('region', TextType::class, [
                'attr' => ['class'=> 'form-control'], 
                'label_attr' => ['class'=> 'fw-bold']
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'nom',
                'attr' => ['class'=> 'form-control'],
                'label_attr' => ['class'=> 'fw-bold']
            ])
            ->add('envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn m-4', 'id' => 'form_envoyer'], 
                'row_attr' => ['class' => 'text-center'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}