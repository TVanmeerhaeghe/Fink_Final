<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;

class ArticleController extends AbstractController
{
    #[Route('/blog', name: 'blog.index', methods:['GET'])]
    public function index(ArticleRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $articles = $paginator->paginate(

            $repository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('pages/articles/index.html.twig', ['articles' => $articles]);
    }

    #[Route('/blog/{id}', name: 'blog.show', methods:['GET'])]
    public function show(): Response
    {
        
    }
}
