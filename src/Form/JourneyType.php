<?php

namespace App\Form;

use App\Entity\Journey;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JourneyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de l\'étape',
                'attr' => [
                    'placeholder' => 'Date de l\'étape',
                    'class' => 'field',
                ],
            ])
            ->add('location', TextType::class, [
                'label' => 'Lieu',
                'attr' => [
                    'placeholder' => 'Lieu de l\'étape',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'tinymce',
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Adresse de l\'étape',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
                'required' => false,
            ])
            ->add('lo', NumberType::class, [
                'label' => 'Longitude',
                'attr' => [
                    'placeholder' => 'Longitude',
                    'class' => 'field',
                ],
                'required' => false,
            ])
            ->add('la', NumberType::class, [
                'label' => 'Latitude',
                'attr' => [
                    'placeholder' => 'Latitude',
                    'class' => 'field',
                ],
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => $options['submit_label'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Journey::class,
            'submit_label' => 'Valider',
        ]);
    }
}
