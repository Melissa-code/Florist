<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'disabled' => true,
            ])
            ->add('name', TextType::class, [
                'label'=> 'Nom de l\'adresse : ',
                'attr'=> [
                    'placeholder'=> "Nom de l'adresse"
                ]
            ])
            ->add('street', TextType::class, [
                'label'=> 'N° voie et ville : ',
                'attr'=> [
                    'placeholder'=> "N° voie et ville"
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label'=> 'Code postal : ',
                'attr'=> [
                    'placeholder'=> "Code postal"
                ]
            ])
            ->add('country', CountryType::class, [
                'label'=> 'Pays : ',
                'attr'=> [
                    'placeholder'=> "Pays"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
