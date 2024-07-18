<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class InscriptionType extends AbstractType
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
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe entrés ne sont pas identiques.',
                'required' => true,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Motdepasse85-',
                        'class' => 'formDisplay',
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
                    ],
                    'second_options' => [
                        'label' => 'Répéter le mot de passse',
                        'attr' => [
                            'placeholder' => 'Motdepasse85-',
                            'class' => 'formDisplay',
                        ],
                        ],
            ])

            ->add('CGU', CheckboxType::class, [
                'required' => true,
                'label' => 'Je confirme avoir pris connaissance des
                            conditions générales d\'utilisation',
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

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'isAdmin' => false,
        ]);
    }
}
