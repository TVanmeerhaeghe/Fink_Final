<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'reservation.index')]
    public function reservation(Request $request,EntityManagerInterface $manager, ManagerRegistry $doctrine, int $id): Response
    {
        $salonRepository = $doctrine->getRepository(Salon::class); 
        $salon = $salonRepository->find($id);

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation, ['salon' => $salon]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existingReservation = $salon->getReservation()->filter(function ($r) use ($reservation) {
                return $r->getDate() == $reservation->getDate();
            })->first();

            if ($existingReservation) {
                $form->get('date')->addError(new FormError('Ce salon n\'est pas disponible a ce moment la'));
            } else {
                $reservation->setUser($this->getUser());
                $reservation->setSalon($salon);
                $manager->persist($reservation);
                $manager->flush();

                $this->addFlash(
                    'reservation',
                    'Votre reservation a bien étais envoyer !'
                );
            }
        }
        return $this->render('pages/reservation/index.html.twig', [
            'salon' => $salon, 'form' => $form
        ]);
    }
}
