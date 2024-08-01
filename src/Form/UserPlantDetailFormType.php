<?php

namespace App\Form;


use App\Entity\Diseases;
use App\Entity\PlantDetail;
use App\Entity\HealthStatus;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserPlantDetailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('HealthStatus', EntityType::class, [
            'class' => HealthStatus::class,
            'label' => 'Comment se porte cette plante',
            'choice_label' => 'Name',
            'query_builder' => function (EntityRepository $er): QueryBuilder{
                return $er->createQueryBuilder('h')
                    ->orderBy('h.Name', 'ASC');        
            },
            'required' => false,
            'multiple' => false,
            'expanded' => false,
            'by_reference' => true,
        ])
        
        ->add('diseases', EntityType::class, [
            'class' => Diseases::class,
            'label' => 'Maladie',
                        'choice_label' => 'Name',
            'query_builder' => function (EntityRepository $er): QueryBuilder{
                return $er->createQueryBuilder('d')
                    ->orderBy('d.Name', 'ASC');
            },
                'required' => false,
                'multiple' => true,
                'expanded' => false,
                'by_reference' => false,
        ])
        ->add('newJournalEntry', TextareaType::class, [
            'label' => 'Journal',
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
