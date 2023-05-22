<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Form\SalonType;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\SalonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
            9
        );

        return $this->render('pages/salon/index.html.twig', ['salons' => $salons, 'form' => $form]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/salons/{id}', name: 'salon.show', methods:['GET'])]
    public function show(Salon $salon): Response
    {
        return $this->render('pages/salon/show.html.twig', ['salon' => $salon]);
    }

    #[IsGranted('ROLE_TATOUEUR')]
    #[Route('/mes-salons', name: 'salon.list', methods:['GET'])]
    //Fonction qui apelle toutes les recettes
    public function showMine(SalonRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $salons = $paginator->paginate(
            $repository->findBy(['Proprietaire'=>$this->getUser()]),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('pages/salon/salon_owner.html.twig', ['salons' => $salons]);
    }

    #[Security("is_granted('ROLE_USER') and user === salon.getProprietaire()")]
    #[Route('/salons/edition/{id}', name: 'salon.edit', methods:['GET', 'POST'])]
    public function edit(Salon $salon, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(SalonType::class, $salon);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $salon = $form->getData();

            $manager->persist($salon);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre salon a été modifié avec succès !'
            );

            return $this->redirectToRoute('salon.list');
        }

        return $this->render('pages/salon/edit.html.twig', ['form' => $form->createView()]);
    }
}
