<?php

namespace App\Form;

use App\Entity\Colors;
use App\Entity\Families;
use App\Entity\Species;
use App\Entity\Seasons;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('color', EntityType::class, [
                'class' => Colors::class,
                'choice_label' => 'Name',
                'placeholder' => 'Select a color',
                'required' => false,
            ])
            ->add('family', EntityType::class, [
                'class' => Families::class,
                'choice_label' => 'Name',
                'placeholder' => 'Select a family',
                'required' => false,
            ])
            ->add('species', EntityType::class, [
                'class' => Species::class,
                'choice_label' => 'Name',
                'placeholder' => 'Select a species',
                'required' => false,
            ])
            ->add('season', EntityType::class, [
                'class' => Seasons::class,
                'choice_label' => 'Name',
                'placeholder' => 'Select a season',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}