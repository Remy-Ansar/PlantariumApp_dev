<?php

namespace App\Form;

use App\Entity\Diseases;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DiseasesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                'label' => 'Nom de la maladie :',
                'attr' => [
                    'placeholder' => 'Rouille', 
                ],
                'required' => true,
            ])
            ->add('Description', TextareaType::class, [
                'label' => 'Description de la maladie: ',
                'attr' => [
                    'placeholder' => 'Les symptômes comprennent...',
                    'row' => 2,
                ],
                'required' => false,
                'sanitize_html' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Diseases::class,
            'sanitize_html' => true,
        ]);
    }
}
