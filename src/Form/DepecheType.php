<?php

namespace App\Form;

use App\Entity\Depeche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class DepecheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextType::class, [
                'label' => 'Texte',
                'attr' => [
                    'placeholder' => 'Consectetur commodo pretium lorem habitasse',
                    'maxlength' => 255,
                    'class' => 'field',
                ],
            ])
            ->add('is_positive', CheckboxType::class, [
                'label' => 'Bonne nouvelle',
                'attr' => [
                    'class' => 'field',
                ],
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depeche::class,
        ]);
    }
}
