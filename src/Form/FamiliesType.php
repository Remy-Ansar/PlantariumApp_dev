<?php

namespace App\Form;

use App\Entity\Families;
use App\Validator\Constraints\Uppercase;
use Symfony\Component\Form\AbstractType;
use App\Validator\Constraints\UniqueEntityField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FamiliesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Name', TextType::class, [
            'label' => 'Nouvelle Famille à ajouter :',
            'attr' => [
                'placeholder' => 'FAMILLE'
            ],
            'required' => false,
            'constraints' => [
                    new Uppercase(),
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
        ]);
    }
}
