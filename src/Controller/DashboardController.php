<?php

namespace App\Controller;

use App\Entity\User;
use App\Enums\Roles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="rf_dashboard")
     * @IsGranted(Roles::ROLE_VIEWER)
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $ur = $em->getRepository(User::class);
        $users = $ur->findBy(
            [],
            ['createdAt' => 'DESC'],
            15
        );

        $usersOnline = $ur->findOnlineUsers();
        $usersCreatedThisMonth = $ur->findUsersCreatedByMonth();
        $totalActiveUsers = $ur->findTotalActiveUsers(true);

        return $this->render('dashboard/dashboard.html.twig', [
            'users' => $users,
            'usersOnline' => $usersOnline,
            'usersCreatedThisMonth' => $usersCreatedThisMonth,
            'totalUsers' => $totalActiveUsers
        ]);
    }
}
