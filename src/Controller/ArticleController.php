<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ArticleController extends AbstractController
{
    #[Route('/blog', name: 'blog.index', methods:['GET'])]
    public function index(ArticleRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $articles = $paginator->paginate(

            $repository->findBy([], ['date' => 'DESC']),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('pages/articles/index.html.twig', ['articles' => $articles]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/blog/{id}', name: 'blog.show', methods:['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('pages/articles/show.html.twig', ['article' => $article]);
    }
}
