<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Salon;
use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\DemandeSalon;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Fink - Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Article', 'fa-regular fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Salon', 'fa-solid fa-shop', Salon::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Demande de contact', 'fa-solid fa-envelope', Contact::class);
        yield MenuItem::linkToCrud('Demande de partenariat', 'fa-solid fa-handshake', DemandeSalon::class);
    }
}
