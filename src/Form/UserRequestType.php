<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\UserRequest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom et nom',
                'attr' => [
                    'class' => 'field',
                    'maxlength' => 255,
                    'placeholder' => 'Dupont Jean',
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('tel', TelType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'class' => 'field',
                    'maxlength' => 64,
                    'placeholder' => '06 01 02 03 04',
                ],
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'attr' => [
                    'class' => 'field',
                    'maxlength' => 255,
                    'placeholder' => 'dupont.jean@example.com',
                ],
                'required' => false,
            ])
            ->add('message', TextareaType::class, [
                'label' => $options['message_label'],
                'attr' => [
                    'class' => 'tinymce',
                ],
                'required' => false,
            ])
            ->add('product', EntityType::class, [
                'label' => 'Produit concerné (optionnel)',
                'class' => Product::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'field',
                ],
                'required' => false,
                'placeholder' => 'Aucun',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserRequest::class,
            'message_label' => 'Message',
        ]);
    }
}
