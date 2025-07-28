<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Un super article',
                    'maxlength' => 255,
                    'class' => 'field',
                ]
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'Sous-titre',
                'attr' => [
                    'placeholder' => 'Ceci est vraiment un super article',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
                'required' => false,
            ])
            ->add('tags', TextType::class, [
                'label' => 'Tags',
                'attr' => [
                    'placeholder' => 'nature, découverte, voyage',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
                'required' => false,
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur',
                'attr' => [
                    'placeholder' => 'Doucet Pascal',
                    'maxlength' => 255,
                    'class' => 'field',
                ]
            ])
            ->add('visible', CheckboxType::class, [
                'label' => 'Article visible',
                'attr' => [
                    'placeholder' => 'Un super article',
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
            'data_class' => Article::class,
            'submit_label' => 'Valider',
        ]);
    }
}
