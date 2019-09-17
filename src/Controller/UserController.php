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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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

        // CHANGE STATUS
        if (
            $request->isMethod('POST') && $request->request->get('change_status',false)
        ) {
            if ($this->isGranted(Roles::ROLE_USER_MANAGEMENT_EDITOR, $user)) {
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

        //UPDATE ROLES
        if (
            $request->isMethod('POST') && $request->request->get('update_roles',false)
        ) {
            if ($this->isGranted(Roles::ROLE_ROLES_MANAGEMENT)) {
                $updateRoles = $request->request->get('update_roles');
                $updateRolesArray = explode(',',$updateRoles);
                $roles = [];
                foreach ($updateRolesArray as $role) {
                    if (Roles::roleExist($role)) {
                        $roles[]=$role;
                    }
                }
                $user->setRoles($roles);
                $this->getDoctrine()->getManager()->flush();
                $rfMessages->addSuccess('Roles for ' . $user->getName()." has been updated successfully");
            } else {
                $rfMessages->addWarning('You don\'t have access to change the roles of this user.');
            }
        }

        $form = $this->getUserForm($user);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'user_form' => $form->createView(),
            'rfMessages' => $rfMessages->getMessages()
        ]);
    }

    protected function getUserForm(User $user)
    {
        $form = $this->createFormBuilder($user)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('telephone', TextType::class)
            ->add('mobile', TextType::class)
            ->add('address', TextareaType::class)
            ->add('zipcode', TextType::class)
            ->getForm();

        return $form;
    }
}
