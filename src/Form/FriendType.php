<?php

namespace App\Form;

use App\Entity\Friend;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints;

class FriendType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname', TextType::class, [
                'label' => 'Nom complet',
                'attr' => [
                    'placeholder' => 'Nom complet',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
                'constraints' => [
                    new Constraints\NotBlank(['message' => 'Le nom est obligatoire'])
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
            ])
            ->add('avatar_url', TextType::class, [
                'label' => 'URL de l\'avatar',
                'attr' => [
                    'placeholder' => 'URL de l\'avatar',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
            ])
            ->add('website_url', TextType::class, [
                'label' => 'URL du site',
                'attr' => [
                    'placeholder' => 'URL du site',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
            ])
            ->add('facebook_url', TextType::class, [
                'label' => 'URL Facebook',
                'attr' => [
                    'placeholder' => 'URL Facebook',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => $options['submit_label'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Friend::class,
            'submit_label' => 'Valider'
        ]);
    }
}
