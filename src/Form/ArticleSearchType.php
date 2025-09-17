<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Rechercher un article...', 'class' => 'field'],
            ])
            ->setMethod('GET')
        ;

        if ($options['is_admin']) {
            $builder->add('h', CheckboxType::class, [
                'label' => 'Articles cachées uniquement',
                'required' => false,
            ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'is_admin' => false,
        ]);
    }

    public function getBlockPrefix(): string { return ''; }

}
