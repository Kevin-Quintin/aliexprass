<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Categories;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AliExprass');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Product', 'fas fa-shopping-cart', Product::class);
        yield MenuItem::linkToCrud('Categorie', 'fas fa-list', Categories::class);
        yield MenuItem::linkToCrud('Carrier', 'fas fa-truck', Carrier::class);
    }
}
