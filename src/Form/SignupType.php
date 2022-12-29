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
use Symfony\Component\Validator\Constraints\Length;

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
                'constraints' => new Length(3, 3, 50),
                'required' => true
            ])
            ->add('name', TextType::class, [
                'label'=> 'Nom :',
                'attr' => [
                    'placeholder'=> 'Saisir votre nom'
                ],
                'constraints' => new Length(3, 3, 50),
                'required' => true
            ])
            ->add('phone', TelType::class, [
                'label'=> 'Téléphone :',
                'attr' => [
                    'placeholder'=> 'Saisir votre n° de téléphone'
                ],
                'constraints' => new Length(10, 10, 30),
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
                'constraints' => new Length(5, 5, 60),
                'required' => true
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                'label' => 'Mot de passe :',
                'attr' => [
                    'placeholder'=> 'Saisir votre mot de passe'
                ],
                'constraints' => new Length(5, 5, 100),
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
