<?php

namespace App\Form;

use App\Entity\Salon;
use App\Entity\Reservation;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReservationType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $salon = $options['salon'];
        $builder
            ->add('date')
            ->add('salon', EntityType::class, [
                'class' => Salon::class,
                'choices' => [$salon],
                'choice_label' => 'nom', 
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => '',
                ],
                'label' => 'Veuillez expliqué rapidement pourquoi vous souhaitez ce rendez-vous',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
                ])
            ->add('preference', ChoiceType::class, [
                'choices' => [
                    'Sur place' => 'Sur place',
                    'Par téléphone' => 'Par téléphone',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ]);
        
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $reservation = $event->getData();
                $form = $event->getForm();
    
                if (!$reservation) {
                    return;
                }
    
                $user = $this->security->getUser();
    
                $reservation->setUser($user);
    
                $form->remove('user_id');
            })
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'salon' => null,
        ]);
    }
}
