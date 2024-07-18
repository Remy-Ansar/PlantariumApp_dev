<?php

namespace App\Form;

use App\Entity\Colors;
use App\Entity\Plants;
use App\Entity\Seasons;
use App\Entity\Species;
use App\Entity\Families;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PlantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('species', EntityType::class, [
            'class' => Species::class,
            'choice_label' => 'Name',
            
        ])  
        ->add('Name', TextType::class, [
            'label' => 'Nom de la nouvelle plante :',
            'attr' => [
                'placeholder' => 'Ma nouvelle plante', 
                'class' => 'formDisplay',
            ],
            'required' => true,
        ])
            
        ->add('families', EntityType::class, [
            'class' => Families::class,
            'choice_label' => 'Name',
        ])

        ->add('Description', TextareaType::class, [
            'label' => 'Description :', 
            'attr' => [
                'placeholder' => 'Votre description de cette plante',
                'row' => 3,
                'class' => 'formDisplay',
            ],
            'required' => false,
        ])
        
        ->add('enable', CheckboxType::class, [
            'label' => 'Visible',
            'required' => false,
            ])

        ->add('seasons', EntityType::class, [
            'class' => Seasons::class,
            'label' => 'Choisissez saisonabilité :',
            'choice_label' => 'Name',
            'multiple' => true,
            'expanded' => false, 
            'by_reference' => true,

        ])

        ->add('categories', EntityType::class, [
            'class' => Categories::class,
            'label' => 'Choisissez la ou les catégories correspondantes :',
            'choice_label' => 'Name',
            'multiple' => true,
            'expanded' => false, 
            'by_reference' => true,
        ])

        ->add('colors', EntityType::class, [
            'class' => Colors::class,
            'label' => 'Choisissez la ou les couleurs de la plante :',
            'choice_label' => 'Name',
            'multiple' => true,
            'expanded' => false, // Set to true if you want checkboxes/radio buttons
            'by_reference' => true,
        ])

        ->add('image', VichImageType::class, [
            'label' => 'Ajouter une image ou une photo de la plante :',
            'required' => false,
            'download_uri' => false,
            'image_uri' => true,
            'asset_helper' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plants::class, 
        ]);
    }
}
