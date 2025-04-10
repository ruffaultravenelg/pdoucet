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
                'constraints' => [
                    new Constraints\NotBlank(['message' => 'Le nom est obligatoire'])
                ]
            ])
            ->add('description')
            ->add('avatar_url')
            ->add('website_url')
            ->add('facebook_url')
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
