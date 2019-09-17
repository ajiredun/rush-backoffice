<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Enums\Roles;

/**
 * @Route("/user")
 * @IsGranted(Roles::ROLE_VIEWER)
 */
class UserController extends AbstractController
{
    /**
     * @Route("/profile-{id}", name="rf_user_profile")
     */
    public function profile(Request $request, User $user)
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
