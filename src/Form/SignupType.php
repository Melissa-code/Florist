<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label'=> 'Prénom :',
                'attr' => [
                    'placeholder'=> 'Saisir votre prénom'
                ],
                'required' => true
            ])
            ->add('name', TextType::class, [
                'label'=> 'Nom :',
                'attr' => [
                    'placeholder'=> 'Saisir votre nom'
                ],
                'required' => true
            ])
            ->add('phone', TelType::class, [
                'label'=> 'Téléphone :',
                'attr' => [
                    'placeholder'=> 'Saisir votre n° de téléphone'
                ],
                'required' => true
            ])
            ->add('birthday',DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance :',
                'required' => true
                ]
            )
            ->add('email', EmailType::class, [
                'label' => 'Email :',
                'attr' => [
                    'placeholder'=> 'Saisir votre email'
                ],
                'required' => true
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                'label' => 'Mot de passe :',
                'attr' => [
                    'placeholder'=> 'Saisir votre mot de passe'
                ],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe :'],
                'second_options' => ['label' => 'Confirmer mot de passe :']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
