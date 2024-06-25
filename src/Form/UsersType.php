<?php

namespace App\Form;

use App\Entity\UserInfos;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre addresse email',
                'required' => false,
                'attr' => [
                    'placeholder' => 'exemple@mail.fr'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe entrés ne sont pas identiques.',
                'required' => true,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Motdepasse85-',
                    ],
                    'constraints' => [
                        new Assert\Regex([
                            'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                            'message' => 'Votre mot de passe doit contenur au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
                        ]),
                        new Assert\NotBlank(),
                        new Assert\Length(
                            max:4096,
                        ),
                    ]
                    ]                  
            ])
            ->add('FirstName', EntityType::class, [
                'class' => UserInfos::class,
                'label' => 'Votre prénom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Jane', 
                ]
            ])
            ->add('LastName', EntityType::class, [
                'class' => UserInfos::class,
                'label' => 'Votre nom', 
                'required' => false,
                'attr' => [
                    'placeholder' => 'Doe',
                ]
                ])
                ->add('Level', EntityType::class, [
                    'class' => UserInfos::class,
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
            'data_class' => Users::class,
            'isAdmin' => false,
        ]);
    }
}
