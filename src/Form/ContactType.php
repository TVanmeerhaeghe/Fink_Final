<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
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
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'input-type',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Prenom',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('email', EmailType:: class, [
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
            ->add('Sujet', TextType:: class, [
                'attr' => [
                    'class' => 'input-type',
                    'minlength' => '2',
                    'maxlength' => '100',
                ],
                'label' => 'Sujet',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Message', TextareaType::class, [
                'attr' => [
                    'class' => 'input-type input-msg',
                    'min' => 1,
                    'max' => 5,
                ],
                'label' => 'Message',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'button',
                ],
                'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
