<?php

namespace App\Form;

use App\Entity\Plants;
use App\Entity\Diseases;
use App\Entity\UserPlants;
use App\Entity\PlantDetail;
use App\Entity\HealthStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserPlantDetailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


        ->add('HealthStatus', HealthStatusType::class, [
            'label' => false
        ])
        ->add('Diseases', EntityType::class, [
            'class' => Diseases::class,
            'choice_label' => 'Name',
            'label' => 'Maladie',
            'required' => false,
            'attr' => [
                    'id' => 'diseases-field', // Add an ID attribute
                ],
        ])
        ->add('newJournalEntry', TextareaType::class, [
            'label' => 'New Journal Entry',
            'mapped' => false,
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlantDetail::class,
            'sanitize_html' => true,
        ]);
    }
}
