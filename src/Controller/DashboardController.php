<?php

namespace App\Controller;

use App\Entity\User;
use App\Enums\UserStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="rf_dashboard")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $ur = $em->getRepository(User::class);
        $users = $ur->findBy(
            [],
            ['createdAt' => 'DESC'],
            20
        );


        return $this->render('dashboard/dashboard.html.twig', [
            'users' => $users
        ]);
    }
}
