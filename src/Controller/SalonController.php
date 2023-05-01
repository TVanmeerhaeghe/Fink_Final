<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Repository\SalonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalonController extends AbstractController
{
    #[Route('/salons', name: 'salon.index')]
    public function index(SalonRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $salons = $paginator->paginate(

            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/salon/index.html.twig', ['salons' => $salons]);
    }

    #[Route('/salons/{id}', name: 'salon.show', methods:['GET'])]
    public function show(Salon $salon): Response
    {
        return $this->render('pages/salon/show.html.twig', ['salon' => $salon]);
    }
}
