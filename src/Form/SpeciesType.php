<?php

namespace App\Form;

use App\Entity\Species;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\AbstractType;
use App\Validator\Constraints\UniqueEntityField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SpeciesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Add the event listener to modify constraints based on the entity state
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $species = $event->getData();

            // Check if the entity is new or existing
            $isNew = $species === null || $species->getId() === null;

            $constraints = [
                new UniqueEntityField([
                    'entityClass' => Species::class,
                    'field' => 'Name',
                ]),
            ];

            if ($isNew) {
                $constraints[] = new NotBlank();
            }

            $form->add('Name', TextType::class, [
                'label' => 'Nouvelle espèce de plante à ajouter :',
                'attr' => [
                    'placeholder' => 'Rose'
                ],
                'required' => $isNew,
                'constraints' => $constraints,
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Species::class,
        ]);
    }
}
