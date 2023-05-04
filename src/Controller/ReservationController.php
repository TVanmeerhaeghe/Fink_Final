<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
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
            // $existingReservation = $salon->getReservation()->filter(function ($r) use ($reservation) {
            //     return $r->getDate() == $reservation->getDate();
            // })->first();

            // if ($existingReservation) {
            //     $form->get('date')->addError(new FormError('Ce salon n\'est pas disponible a ce moment la'));
            // // } else {
                $reservation->setUser($this->getUser());
                $reservation->setSalon($salon);
                $manager->persist($reservation);
                $manager->flush();

                $this->addFlash(
                    'reservation',
                    'Votre reservation a bien étais envoyer !'
                );
            // }
        }
        return $this->render('pages/reservation/index.html.twig', [
            'salon' => $salon, 'form' => $form
        ]);
    }

    #[Route('/reservation/utilisateur/{id}', name: 'reservation.show.user')]
    public function showUser(ReservationRepository $repository, PaginatorInterface $paginator, Request $request)
    {
        $reservations = $paginator->paginate(

            $repository->findBy(['user'=>$this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/reservation/show_user.html.twig', ['reservations' => $reservations]);
    }

    #[Route('/reservation/salon/{id}', name: 'reservation.show.salon')]
    public function showSalon(ReservationRepository $repository, PaginatorInterface $paginator, Request $request)
    {
        $queryBuilder = $repository->createQueryBuilder('r')
        ->innerJoin('r.salon', 's')
        ->where('s.Proprietaire = :user_id')
        ->setParameter('user_id', $this->getUser())
        ->orderBy('r.date', 'DESC');

        $reservations = $paginator->paginate(

            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/reservation/show_salon.html.twig', ['reservations' => $reservations]);
    }
}
