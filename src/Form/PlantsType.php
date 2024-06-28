<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Colors;
use App\Entity\Families;
use App\Entity\Plants;
use App\Entity\Seasons;
use App\Entity\Species;
use App\Entity\UserPlants;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Description')

            ->add('enable')
            ->add('userPlants', EntityType::class, [
                'class' => UserPlants::class,
                'choice_label' => 'id',
            ])
            ->add('seasons', EntityType::class, [
                'class' => Seasons::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('families', EntityType::class, [
                'class' => Families::class,
                'choice_label' => 'id',
            ])
            ->add('species', EntityType::class, [
                'class' => Species::class,
                'choice_label' => 'id',
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('colors', EntityType::class, [
                'class' => Colors::class,
                'choice_label' => 'id',
                'multiple' => true,
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
