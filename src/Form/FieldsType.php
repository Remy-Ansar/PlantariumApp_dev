<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('species', SpeciesType::class, [
                'label' => false,
            ])
            ->add('families', FamiliesType::class, [
                'label' => false,
            ])
            ->add('colors', ColorsType::class, [
                'label' => false,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // No data_class specified because it's a composite form
        ]);
    }
}
