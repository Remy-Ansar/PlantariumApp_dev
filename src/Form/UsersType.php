<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\UserInfos;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre addresse email',
                'required' => false,
                'attr' => [
                    'placeholder' => 'exemple@mail.fr',
                    'class' => 'formDisplay',
                ]
            ])
            ->add('password', PasswordType::class, [
                'invalid_message' => 'Les mots de passe entrés ne sont pas identiques.',
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'message' => 'Votre mot de passe doit contenur au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
                    ]),
                    new Assert\NotBlank(),
                    new Assert\Length(
                        max: 4096,
                    ),
                ]
            ])
            ->add('userInfos', ProfileType::class, [
                'label' => false,
            ]);

        if ($options['isAdmin']) {
            $builder->remove('password')
                ->add('roles', ChoiceType::class, [
                    'label' => 'Rôles',
                    'choices' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Editeur' => 'ROLE_EDITOR',
                        'Administrateur' => 'ROLE_ADMIN',

                    ],
                    'multiple' => true,
                    'expanded' => true,
                ]);
        }
        // ->add('FirstName', EntityType::class, [
        //     'class' => UserInfos::class,
        //     'label' => 'Votre prénom',
        //     'required' => false,
        //     'placeholder' => 'Prénom', 
        //     'query_builder' => function (EntityRepository $entityRepository): QueryBuilder {
        //         return $entityRepository->createQueryBuilder('prnm')
        //             ->andWhere('prnm.FirstName = :FirstName')
        //             ->orderBy('prnm.FirstName', 'ASC');
        //     },
        // ])
        // ->add('LastName', EntityType::class, [
        //     'class' => UserInfos::class,
        //     'label' => 'Votre nom', 
        //     'required' => false,
        //     'attr' => [
        //         'placeholder' => 'Doe',
        //     ]
        //     ])
        //     ->add('Level', EntityType::class, [
        //         'class' => UserInfos::class,
        //         'label' => 'Votre niveau de jardinage',
        //         'required' => false,
        //         'choices' => array_combine(UserInfos::getAvailableLevels(), UserInfos::getAvailableLevels()),
        //         'multiple' => false,
        //         'expanded' => false,
        //     ]); 

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'isAdmin' => false,
            'sanitize_html' => true,
        ]);
    }
}
