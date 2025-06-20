<?php

namespace App\Form;

use App\Entity\Friend;
use Eckinox\TinymceBundle\Form\Type\TinymceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('description', TinymceType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('avatar', FileType::class, [
                'label' => $options['avatar_label'],
                'attr' => [
                    'class' => 'field',
                ],
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG, PNG, GIF ou WebP)',
                    ])
                ],
            ])
            ->add('website_url', TextType::class, [
                'label' => 'URL du site',
                'attr' => [
                    'placeholder' => 'URL du site',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
                'required' => false,
            ])
            ->add('facebook_url', TextType::class, [
                'label' => 'URL Facebook',
                'attr' => [
                    'placeholder' => 'URL Facebook',
                    'maxlength' => 255,
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
            'data_class' => Friend::class,
            'submit_label' => 'Valider',
            'avatar_label' => "Modifier l'image"
        ]);
    }
}
