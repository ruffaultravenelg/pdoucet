<?php

namespace App\Form;

use App\Entity\IndexLink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class IndexLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du lien',
                'attr' => [
                    'placeholder' => 'Articles',
                    'class' => 'field',
                ],
            ])
            ->add('image', FileType::class, [
                'label' => $options['image_label'],
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
            ->add('url', TextType::class, [
                'label' => 'URL',
                'attr' => [
                    'placeholder' => '/articles',
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
            'data_class' => IndexLink::class,
            'submit_label' => 'Valider',
            'image_label' => "Modifier l'image"
        ]);
    }
}
