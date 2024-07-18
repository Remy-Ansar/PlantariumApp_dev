<?php

namespace App\Form;

use App\Entity\Colors;
use Symfony\Component\Form\AbstractType;
use App\Validator\Constraints\UniqueEntityField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ColorsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('Name', TextType::class, [
            'label' => 'Nouvelle couleur de plante à ajouter :',
            'attr' => [
                'placeholder' => 'couleur',
                'class' => 'formDisplay',
            ],
            'constraints' => [
                new NotBlank(),
                new UniqueEntityField([
                    'entityClass' => Colors::class,
                    'field' => 'Name',
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Colors::class,
        ]);
    }
}