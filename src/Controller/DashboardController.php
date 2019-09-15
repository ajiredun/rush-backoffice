<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="rf_dashboard")
     */
    public function index()
    {
        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
