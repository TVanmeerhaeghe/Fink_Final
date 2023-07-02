<?php

namespace App\Form;

use App\Entity\Salon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SalonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'attr' => [
                    'class' => 'input-type',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Adresse', TextType::class, [
                'attr' => [
                    'class' => 'input-type',
                    'minlength' => '2',
                    'maxlength' => '100',
                ],
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Telephone', IntegerType::class, [
                'attr' => [
                    'class' => 'input-type',
                    'min' => 1,
                    'max' => 999999999,
                ],
                'required' => false,
                'label' => 'Téléphone',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\LessThan(999999999)
                ]
            ])
            ->add('Description', TextareaType::class, [
                'attr' => [
                    'class' => 'input-type input-msg',
                ],
                'label' => 'Description rapide',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('Ville', TextType::class, [
                'attr' => [
                    'class' => 'input-type',
                    'minlength' => '2',
                    'maxlength' => '100',
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Email', EmailType:: class, [
                'attr' => [
                    'class' => 'input-type',
                    'minlength' => '2',
                    'maxlength' => '180',
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 180]),
                    new Assert\Email()
                ]
            ])
            ->add('Style', ChoiceType::class, [
                'choices' => [
                    'Old School' => 'Old School',
                    'New School' => 'New School',
                    'Blackwork' => 'Blackwork',
                    'Dotwork' => 'Dotwork',
                    'Tribal' => 'Tribal',
                    'Realiste' => 'Realiste',
                    'Aquarelle' => 'Aquarelle',
                    'Neo-traditionnel' => 'Neo-traditionnel',
                    'Geometrique' => 'Geometrique',
                    'Trash Polka' => 'Trash Polka',
                    'Maori' => 'Maori',
                    'Japonais' => 'Japonais',
                    'Calligraphie' => 'Calligraphie',
                    'Minimaliste' => 'Minimaliste',
                    'Symbole' => 'Symbole',
                    'Lettrage' => 'Lettrage',
                    'Ornemental' => 'Ornemental',
                    'Bio-mecanique' => 'Bio-mecanique',
                    'Cartoon' => 'Cartoon',
                    'Portrait' => 'Portrait',
                    'Graffiti' => 'Graffiti',
                    'Couleur' => 'Couleur',
                    'Gravure' => 'Gravure',
                    'Religieux' => 'Religieux',
                    'Fantaisie' => 'Fantaisie',
                    'Abstrait' => 'Abstrait'
                ],
                'attr' => [
                    'class' => 'input-type',
                ],
                'label' => 'Quel style de tatouages pratiquez vous principalement ?',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('imageFile', VichImageType::class,[
                'label' => 'Photo de la devanture',
                'attr' => [
                    'class' => 'button'
                ],
                'label_attr' => [
                    'class' => ''
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'button',
                ],
                'label' => 'Modifier'
            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salon::class,
        ]);
    }
}
