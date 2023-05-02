<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\SalonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index', methods: ['GET', 'POST'])]
    public function index(Request $request, SalonRepository $repository): Response
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

        return $this->render('pages/home/index.html.twig', ['form' => $form]);
    }
}
