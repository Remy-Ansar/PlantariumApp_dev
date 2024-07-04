<?php

namespace App\Form;

use App\Entity\Families;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Validator\Constraints\Uppercase;
use Symfony\Component\Form\AbstractType;
use App\Validator\Constraints\UniqueEntityField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FamiliesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Add the event listener to modify constraints based on the entity state
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            // Check if the entity is new or existing
            $isNew = null === $data || null === $data->getId();

            $constraints = [
                new UniqueEntityField([
                    'entityClass' => Families::class,
                    'field' => 'Name',
                ]),
            ];

            if ($isNew) {
                $constraints[] = new NotBlank();
            }

            $form->add('Name', TextType::class, [
                'label' => 'Nouvelle famille de plante à ajouter (en majuscule) :',
                'attr' => [
                    'placeholder' => 'FAMILLE'
                ],
                'required' => $isNew,
                'constraints' => $constraints,
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Families::class,
        ]);
    }
}