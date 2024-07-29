<?php

namespace App\Form;

use App\Entity\Plants;
use App\Entity\Seasons;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SeasonsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', ChoiceType::class, [
                'label' => 'Choisissez la saison souhaitée',
                'required' => false, 
                'choices' => array_combine(Seasons::getavailableSeasons(),Seasons::getavailableSeasons()),
                'multiple' => true,
                'expanded' => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seasons::class,
            'sanitize_html' => true,
        ]);
    }
}
