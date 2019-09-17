<?php

namespace App\Controller;

use App\Entity\User;
use App\Enums\UserStatus;
use App\Service\RfMessages;
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
    public function profile(Request $request, User $user, RfMessages $rfMessages)
    {

        if (
            $request->isMethod('POST') && $request->request->get('change_status',false)
        ) {
            if ($this->isGranted('ROLE_ADMIN_ARTICLE')) {
                $statusToChange = $request->request->get('change_status');
                if (UserStatus::getStatus($statusToChange)) {
                    $user->setStatus($statusToChange);
                    $this->getDoctrine()->getManager()->flush();
                    $rfMessages->addSuccess('The status for ' . $user->getName()." has been changed to ". $statusToChange . " successfully");
                } else {
                    $rfMessages->addError('Invalid Status');
                }
            } else {
                $rfMessages->addWarning('You don\'t have access to change the status of this user.');
            }
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'rfMessages' => $rfMessages->getMessages()
        ]);
    }
}
