<?php

namespace App\Form;

use App\Entity\Colors;
use App\Entity\Plants;
use App\Entity\Seasons;
use App\Entity\Species;
use App\Entity\Families;
use App\Form\SeasonType;
use App\Entity\Categories;
use App\Entity\UserPlants;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use App\Repository\SeasonsRepository;
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
        ->add('Name', TextType::class, [
            'label' => 'Nom de la nouvelle plante',
            'attr' => [
                'placeholder' => 'Ma nouvelle plante' 
            ],
            'required' => true,
        ])
        
        ->add('LatinName', TextType::class, [
            'label' => 'Nom latin de la nouvelle plante',
            'attr' => [
                'placeholder' => 'Ma nouvelle plante' 
            ],
            'required' => false,
        ])
        
        ->add('Description', TextareaType::class, [
            'label' => 'Description', 
            'attr' => [
                'placeholder' => 'Votre description de cette plante',
                'row' => 3,
            ],
            'required' => false,
        ])
        
        ->add('enable', CheckboxType::class, [
            'label' => 'Activer',
            ])
            ->add('seasons', EntityType::class, [
                'class' => Seasons::class,
                'label' => 'Choisissez la ou les saisons correspondantes',
                'choice_label' => 'Name',
                'multiple' => true,
                'expanded' => false, // Set to true if you want checkboxes/radio buttons
                'by_reference' => true,
                // 'query_builder' => function (EntityRepository $entityRepository): QueryBuilder {
                //     return $entityRepository->createQueryBuilder('season')
                //         // ->andWhere('season.Name = :Name')
                //         // ->setParameter('Name', 'Printemps')
                //         ->orderBy('season.Name', 'ASC');
                // }
            ])
            ->add('families', EntityType::class, [
                'class' => Families::class,
                'choice_label' => 'Name',
            ])
            ->add('species', EntityType::class, [
                'class' => Species::class,
                'choice_label' => 'Name',
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                 'label' => 'Choisissez la ou les catégories correspondantes',
                'choice_label' => 'Name',
                'multiple' => true,
                'expanded' => false, // Set to true if you want checkboxes/radio buttons
                'by_reference' => true,
            ])

            ->add('colors', EntityType::class, [
                'class' => Colors::class,
                'choice_label' => 'Name',
                'multiple' => true,
                'multiple' => true,
                'expanded' => false, // Set to true if you want checkboxes/radio buttons
                'by_reference' => true,
            ])

            ->add('image', VichImageType::class, [
                'label' => 'Image',
                'required' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plants::class, 
        ]);
    }
}
