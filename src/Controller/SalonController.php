<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\SalonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalonController extends AbstractController
{
    #[Route('/salons', name: 'salon.index', methods:['GET', 'POST'])]
    public function index(SalonRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $searchData = new SearchData;
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $searchData->page = $request->query->getInt('page', 1);
            //Methode perso pour trouver via la recherche
            $salonsSearch = $repository->findBySearch($searchData);

            return $this->render('pages/salon/search.html.twig', ['form' => $form->createView(), 'salonsSearch' => $salonsSearch]);
        }
        
        $salons = $paginator->paginate(

            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/salon/index.html.twig', ['salons' => $salons, 'form' => $form]);
    }

    #[Route('/salons/{id}', name: 'salon.show', methods:['GET'])]
    public function show(Salon $salon): Response
    {
        return $this->render('pages/salon/show.html.twig', ['salon' => $salon]);
    }
}
