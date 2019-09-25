<?php

namespace App\Controller;

use App\Entity\User;
use App\Enums\Roles;
use App\Repository\PageRepository;
use App\Repository\UserRepository;
use App\Service\RfMessages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="rf_dashboard")
     * @IsGranted(Roles::ROLE_VIEWER)
     */
    public function dashboard(UserRepository $userRepository, PageRepository $pageRepository )
    {
        $users = $userRepository->findBy(
            [],
            ['createdAt' => 'DESC'],
            15
        );



        $usersOnline = $userRepository->findOnlineUsers();
        $usersCreatedThisMonth = $userRepository->findUsersCreatedByMonth();
        $totalActiveUsers = $userRepository->findTotalActiveUsers(true);

        $pagesPublished = $pageRepository->findBy(['published'=>true]);
        $pagesCreatedThisMonth = $pageRepository->findPagesCreatedByMonth();
        $totalPages = $pageRepository->findAll();

        return $this->render('dashboard/dashboard.html.twig', [
            'users' => $users,
            'usersOnline' => $usersOnline,
            'usersCreatedThisMonth' => $usersCreatedThisMonth,
            'totalUsers' => $totalActiveUsers,
            'totalPages' => $totalPages,
            'pagesCreatedThisMonth' => $pagesCreatedThisMonth,
            'pagesPublished' => $pagesPublished,
        ]);
    }
}
