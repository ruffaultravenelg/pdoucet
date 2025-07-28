<?php

namespace App\Form;

use App\Entity\IndexLink;
use App\Entity\Page;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'label' => $options['image_label'],
                'attr' => [
                    'class' => 'field',
                ],
                'mapped' => false,
                'required' => $options['image_label'] !== 'Modifier l\'image',
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
            ->add('page', EntityType::class, [
                'class' => Page::class,
                'choice_label' => 'name',
                'label' => 'Page liée',
                'required' => false,
                'placeholder' => 'Utiliser une URL',
                'attr' => [
                    'class' => 'field',
                ],
            ])
            ->add('url', TextType::class, [
                'label' => 'URL',
                'attr' => [
                    'placeholder' => '/articles',
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
            'data_class' => IndexLink::class,
            'submit_label' => 'Valider',
            'image_label' => "Modifier l'image"
        ]);
    }
}
