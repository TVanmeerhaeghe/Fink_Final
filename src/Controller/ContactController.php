<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Entity\DemandeSalon;
use App\Form\DemandeSalonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    #[IsGranted('ROLE_USER')]
    #[Route('/contact/demande_partenariat', name: 'contact.partenariat')]
    public function demandeSalon(Request $request, EntityManagerInterface $manager): Response
    {
        $demande = new DemandeSalon();
        $salon= new Salon();

        $form = $this->createForm(DemandeSalonType::class, $demande);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $demande->setPropietaire($this->getUser());
            $demande = $form->getData();

            $salon->setNom($demande->getNom());
            $salon->setEmail($demande->getEmail());
            $salon->setAdresse($demande->getAdresse());
            $salon->setTelephone($demande->getTelephone());
            $salon->setVille($demande->getVille());
            $salon->setDescription($demande->getDescription());
            $salon->setImageName($demande->getImageName());
            $salon->setSiret($demande->getSiret());
            $salon->setStyle($demande->getStyle());
            $salon->setProprietaire($this->getUser());
            $salon->setIsTrusted(false);

            $manager->persist($demande);
            $manager->persist($salon);
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
