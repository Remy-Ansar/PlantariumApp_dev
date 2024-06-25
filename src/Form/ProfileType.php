<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\UserInfos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName', TextType::class, [
                'label' => 'Votre prénom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Jane', 
                ]
            ])
            ->add('LastName', TextType::class, [
                'label' => 'Votre nom', 
                'required' => false,
                'attr' => [
                    'placeholder' => 'Doe',
                ]
                ])
                ->add('Level', ChoiceType::class, [
                    'label' => 'Votre niveau de jardinage',
                    'required' => false,
                    'choices' => array_combine(UserInfos::getAvailableLevels(), UserInfos::getAvailableLevels()),
                    'multiple' => false,
                    'expanded' => false,
                ]);
        }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserInfos::class,
        ]);
    }
}
