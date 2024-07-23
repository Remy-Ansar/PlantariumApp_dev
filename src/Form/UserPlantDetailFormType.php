<?php

namespace App\Form;

use App\Entity\Plants;
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
            
            ->add('userPlants', EntityType::class, [
                'class' => UserPlants::class,
                'choice_label' => 'id',
            ])
            ->add('Plant', EntityType::class, [
                'class' => Plants::class,
                'choice_label' => 'id',
            ])
            ->add('HealthStatus', EntityType::class, [
                'class' => HealthStatus::class,
                'choice_label' => 'id',
            ])

            ->add('Journal', TextareaType::class, [
                'label' => 'Journal :', 
                'attr' => [
                    'placeholder' => 'Journal de ma plante',
                    'row' => 4,
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlantDetail::class,
        ]);
    }
}
