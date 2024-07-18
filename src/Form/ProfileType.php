<?php

namespace App\Form;

use App\Entity\UserInfos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
                    'class' => 'formDisplay',
                ]
            ])
            ->add('LastName', TextType::class, [
                'label' => 'Votre nom', 
                'required' => false,
                'attr' => [
                    'placeholder' => 'Doe',
                    'class' => 'formDisplay',
                ]
                ])
                ->add('Level', ChoiceType::class, [
                    'label' => 'Votre niveau de jardinage',
                    'required' => false,
                    'choices' => array_combine(UserInfos::getAvailableLevels(), UserInfos::getAvailableLevels()),
                    'multiple' => false,
                    'expanded' => false,
                ])
            ->add('image', VichImageType::class, [
                'label' => 'Votre photo de profil',
                'required' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
            ]);
        }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserInfos::class,
        ]);
    }
}
