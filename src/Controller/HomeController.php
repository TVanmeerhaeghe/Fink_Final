<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Entity\Article;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\SalonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index', methods: ['GET', 'POST'])]
    public function index(Request $request, SalonRepository $repository, EntityManagerInterface $manager): Response
    {
        $salons = $manager->createQueryBuilder()
            ->select('s')
            ->from(Salon::class, 's')
            ->where('s.isTrusted = :trusted')
            ->setParameter('trusted', true)
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
        
        $articles = $manager->createQueryBuilder('a')
            ->select('a')
            ->from(Article::class, 'a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();

        $searchData = new SearchData;
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $searchData->page = $request->query->getInt('page', 1);
            //Methode perso pour trouver via la recherche
            $salonsSearch = $repository->findBySearch($searchData);

            return $this->render('pages/salon/search.html.twig', ['form' => $form->createView(), 'salonsSearch' => $salonsSearch]);
        }

        return $this->render('pages/home/index.html.twig', ['form' => $form, 'salons' => $salons, 'articles' => $articles]);
    }

    #[Route('/quiz', 'home.quiz', methods: ['GET'])]
    public function quiz(): Response
    {
        return $this->render('pages/home/quiz.html.twig');
    }

    #[Route('/qui-sommes-nous', 'home.qsn', methods: ['GET'])]
    public function decouvrir(): Response
    {
        return $this->render('pages/home/qsn.html.twig');
    }
}
