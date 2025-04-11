<?php

namespace App\Form;

use App\Entity\HeartPic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeartPicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Mon super film',
                    'class' => 'field',
                ],
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'Sous-titre',
                'attr' => [
                    'placeholder' => 'Film / Série',
                    'class' => 'field',
                ],
            ])
            ->add('text', TextType::class, [
                'label' => 'Texte',
                'attr' => [
                    'placeholder' => 'Une courte description du film',
                    'class' => 'field',
                ],
            ])
            ->add('image', TextType::class, [
                'label' => 'Image',
                'attr' => [
                    'placeholder' => 'film.png',
                    'class' => 'field',
                ],
            ])
            ->add('link', TextType::class, [
                'label' => 'Lien',
                'attr' => [
                    'placeholder' => 'https://www.example.com',
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
            'data_class' => HeartPic::class,
            'submit_label' => 'Valider'
        ]);
    }
}
