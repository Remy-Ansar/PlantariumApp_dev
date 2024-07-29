<?php

namespace App\Form;

use App\Entity\Species;
use Symfony\Component\Form\AbstractType;
use App\Validator\Constraints\UniqueEntityField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SpeciesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('Name', TextType::class, [
            'label' => 'Nouvelle espèce de plante à ajouter :',
            'attr' => [
                'placeholder' => 'Taraxacum'
            ],
            'constraints' => [
                new NotBlank(),
                new UniqueEntityField([
                    'entityClass' => Species::class,
                    'field' => 'Name',
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Species::class,
            'sanitize_html' => true,
        ]);
    }
}
