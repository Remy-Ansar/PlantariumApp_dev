<?php

namespace App\Form;

use App\Entity\Diseases;
use App\Entity\HealthStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class HealthStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('Name', ChoiceType::class, [
                'label' => 'Comment se porte cette plante',
                'required' => false,
                'choices' => array_combine(HealthStatus::getAvailableStatus(), HealthStatus::getAvailableStatus()),
                'attr' => [
                    'id' => 'health-status-field',
                ],
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HealthStatus::class,
            'sanitize_html' => true,
        ]);
    }
}
