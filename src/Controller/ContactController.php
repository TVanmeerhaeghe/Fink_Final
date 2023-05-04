<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Entity\DemandeSalon;
use App\Form\DemandeSalonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact.index')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $contact = new Contact();

        if($this->getUser()) {
            $contact->setNom($this->getUser()->getNom())
            ->setPrenom($this->getUser()->getPrenom())
            ->setEmail($this->getUser()->getEmail());
        }

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre message à été envoyé avec succès !'
            );

            return $this->redirectToRoute('contact.index');
        }
        
        return $this->render('pages/contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact/demande_partenariat', name: 'contact.partenariat')]
    public function demandeSalon(Request $request, EntityManagerInterface $manager): Response
    {
        $demande = new DemandeSalon();

        $form = $this->createForm(DemandeSalonType::class, $demande);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $demande->setPropietaire($this->getUser());
            $demande = $form->getData();

            $manager->persist($demande);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre demande à été envoyé avec succès ! Nos équipes reviendrons vers vous une fois les vérification faite'
            );

            return $this->redirectToRoute('contact.partenariat');
        }

        return $this->render('pages/contact/partenariat.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}