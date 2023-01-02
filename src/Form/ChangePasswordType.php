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

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Prénom :'
            ])
            ->add('name', TextType::class, [
                'disabled' => true,
                'label' => 'Nom :'
            ])
            ->add('phone', TelType::class, [
                'disabled' => true,
                'label' => 'Téléphone :'
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'disabled' => true,
                'label' => 'Date de naissance :'
            ])
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Email :',
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Mot de passe actuel :',
                'mapped' => false,
                'attr' => [
                    'placeholder'=> 'Saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                'constraints' => new Length(5, 5, 100),
                'required' => true,
                'first_options' => [
                    'label' => 'Nouveau mot de passe :',
                    'attr' => [
                        'placeholder'=> 'Saisir votre nouveau mot de passe'
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer nouveau mot de passe :',
                    'attr' => [
                        'placeholder'=> 'Confirmer nouveau mot de passe'
                    ],
                ]
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
