<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/reservation/{id}', name: 'reservation.index', methods: ['GET', 'POST'])]
    public function reservation(Request $request,EntityManagerInterface $manager, ManagerRegistry $doctrine, int $id): Response
    {
        $salonRepository = $doctrine->getRepository(Salon::class); 
        $salon = $salonRepository->find($id);

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation, ['salon' => $salon]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setUser($this->getUser());
            $reservation->setSalon($salon);
            $reservation->setIsConfirmed(false);
            $manager->persist($reservation);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre reservation a bien été envoyée !'
            );
        }
        return $this->render('pages/reservation/index.html.twig', [
            'salon' => $salon, 'form' => $form
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/reservation/utilisateur/{id}', name: 'reservation.show.user', methods: ['GET', 'POST'])]
    public function showUser(ReservationRepository $repository, PaginatorInterface $paginator, Request $request)
    {
        $reservations = $paginator->paginate(

            $repository->findBy(['User'=>$this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/reservation/show_user.html.twig', ['reservations' => $reservations]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/reservation/utilisateur/supression/{id}', name: 'reservation.delete', methods:['GET'])]
    public function delete(EntityManagerInterface $manager, Reservation $reservation): Response
    {
        $manager->remove($reservation);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre réservation a été annulée avec succès !'
        );

        return $this->redirectToRoute('reservation.show.user', ['id' => $this->getUser()->getId()]);
    }

    #[IsGranted('ROLE_TATOUEUR')]
    #[Route('/reservation/salon/{id}', name: 'reservation.show.salon', methods: ['GET', 'POST'])]
    public function showSalon(ReservationRepository $repository, PaginatorInterface $paginator, Request $request)
    {
        $queryBuilder = $repository->createQueryBuilder('r')
            ->innerJoin('r.Salon', 's')
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

    #[Route('/reservation/salon/confirmation/{id}', name: 'reservation.confirm.salon')]
    public function confirm(Reservation $reservation, EntityManagerInterface $entityManager, Security $security)
    {
        $user = $security->getUser();

        $reservation->setIsConfirmed(true);
        $entityManager->flush();

        return $this->redirectToRoute('reservation.show.salon', ['id' => $user->getId()]);
    }
}
