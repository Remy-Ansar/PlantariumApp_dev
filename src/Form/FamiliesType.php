<?php

namespace App\Form;

use App\Entity\Families;
use Symfony\Component\Form\AbstractType;
use App\Validator\Constraints\UniqueEntityField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FamiliesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('Name', TextType::class, [
            'label' => 'Nouvelle famille de plante à ajouter (en majuscule) :',
            'attr' => [
                'placeholder' => 'FAMILLE',
                'class' => 'formDisplay',
            ],
            'constraints' => [
                new NotBlank(),
                new UniqueEntityField([
                    'entityClass' => Families::class,
                    'field' => 'Name',
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Families::class,
            'sanitize_html' => true,
        ]);
    }
}