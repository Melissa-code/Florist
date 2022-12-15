<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Discount;
use App\Entity\Flower;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FlowerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('content')
            ->add('isNew')
            //->add('image')
            ->add('imageFile',
                FileType::class, [
                    'required' => false,
                    'mapped' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/jpg'
                            ],
                            'mimeTypesMessage' => 'Veuillez choisir un formar valide'
                        ])
                    ]
                ])
            ->add('discount', EntityType::class, [
                'class' => Discount::class,
                'choice_label' => 'value'
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flower::class,

        ]);
    }
}
