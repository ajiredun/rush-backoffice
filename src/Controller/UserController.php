<?php

namespace App\Controller;

use App\Entity\User;
use App\Enums\UserStatus;
use App\Repository\UserRepository;
use App\Service\RfMessages;
use App\Service\SearchParams;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Enums\Roles;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Knp\Component\Pager\PaginatorInterface;

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
            $request->isMethod('POST') && $request->request->get('change_status', false)
        ) {
            if ($this->isGranted(Roles::ROLE_USER_MANAGEMENT_EDITOR, $user)) {
                $statusToChange = $request->request->get('change_status');
                if (UserStatus::getStatus($statusToChange)) {
                    $user->setStatus($statusToChange);
                    $this->getDoctrine()->getManager()->flush();
                    $rfMessages->addSuccess('The status for ' . $user->getName() . " has been changed to " . $statusToChange . " successfully");
                } else {
                    $rfMessages->addError('Invalid Status');
                }
            } else {
                $rfMessages->addWarning('You don\'t have access to change the status of this user.');
            }
        }

        //UPDATE ROLES
        if (
            $request->isMethod('POST') && $request->request->get('update_roles', false)
        ) {
            if ($this->isGranted(Roles::ROLE_ROLES_MANAGEMENT)) {
                $updateRoles = $request->request->get('update_roles');
                $updateRolesArray = explode(',', $updateRoles);
                $roles = [];
                foreach ($updateRolesArray as $role) {
                    if (Roles::roleExist($role)) {
                        $roles[] = $role;
                    }
                }
                $user->setRoles($roles);
                $this->getDoctrine()->getManager()->flush();
                $rfMessages->addSuccess('Roles for ' . $user->getName() . " has been updated successfully");
            } else {
                $rfMessages->addWarning('You don\'t have access to change the roles of this user.');
            }
        }

        //EDIT USER INFO
        $form = $this->getUserForm($user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('rf_user_profile', ['id' => $user->getId(), 'rfsuccess' => $user->getName() . ' details has been updated successfully']);
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'user_form' => $form->createView(),
            'rfMessages' => $rfMessages->getMessages()
        ]);
    }

    /**
     * @Route("/add", name="rf_user_add")
     * @IsGranted(Roles::ROLE_USER_MANAGEMENT_EDITOR)
     */
    public function add(Request $request, RfMessages $rfMessages, UserRepository $userRepository, UserManager $userManager)
    {
        $form = $this->getUserForm(new User(), true);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            if (!$userManager->isUserExist($user->getEmail())) {
                if ($user->getPassword() == $form['confirmpassword']->getData()) {
                    $status = UserStatus::INACTIVE;
                    if ($form['sendactivationmail'] == "no") {
                        $status = UserStatus::ACTIVE;
                    }
                    $userManager->createUserFromObject($user,[],$status);

                    $rfMessages->addSuccess($user->getName() . ' details has been created successfully');

                    return $this->redirectToRoute('rf_user_profile', ['id' => $user->getId()]);
                } else {
                    $rfMessages->addError('The passwords you entered don\'t match. ');
                }
            } else {
                $rfMessages->addError('This email address already exist');
            }
        }

        $usersOnline = $userRepository->findOnlineUsers();
        $usersCreatedThisMonth = $userRepository->findUsersCreatedByMonth();
        $totalActiveUsers = $userRepository->findTotalActiveUsers(true);

        return $this->render('user/add.html.twig', [
            'rfMessages' => $rfMessages->getMessages(),
            'user_form' => $form->createView(),
            'usersOnline' => $usersOnline,
            'usersCreatedThisMonth' => $usersCreatedThisMonth,
            'totalUsers' => $totalActiveUsers,
        ]);
    }

    /**
     * @Route("/list", name="rf_user_list")
     */
    public function list(Request $request, RfMessages $rfMessages, UserRepository $userRepository, PaginatorInterface $paginator, SearchParams $searchParams)
    {

        $searchParams->setCurrentSector('userlist');
        $pagination = $paginator->paginate(
            $userRepository->getWithSearchQueryBuilder($searchParams),
            $request->query->getInt('page', 1),
            20/*limit per page*/
        );

        $usersOnline = $userRepository->findOnlineUsers();
        $usersCreatedThisMonth = $userRepository->findUsersCreatedByMonth();
        $totalActiveUsers = $userRepository->findTotalActiveUsers(true);

        return $this->render('user/list.html.twig', [
            'rfMessages' => $rfMessages->getMessages(),
            'usersOnline' => $usersOnline,
            'usersCreatedThisMonth' => $usersCreatedThisMonth,
            'totalUsers' => $totalActiveUsers,
            'pagination' => $pagination,
        ]);
    }

    protected function getUserForm(User $user, $creation = false)
    {
        $form = $this->createFormBuilder($user)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('telephone', TextType::class, ['required' => false])
            ->add('mobile', TextType::class, ['required' => false])
            ->add('address', TextareaType::class, ['required' => false])
            ->add('zipcode', TextType::class, ['required' => false])
            ->add('country', TextType::class, ['required' => false]);

        if ($creation) {
            $form->add('email', EmailType::class);
            $form->add('password', PasswordType::class);
            $form->add('confirmpassword', PasswordType::class, ['mapped' => false, 'label' => "Confirm Password"]);

            $form->add('sendactivationmail', ChoiceType::class, [
                    'choices' => array(
                        'Send' => "yes",
                        'Do not send' => "no"
                    ),
                    'multiple' => false,
                    'expanded' => true,
                    'mapped' => false,
                    'label' => "Send activation mail?"
                ]
            );
        }

        return $form->getForm();
    }
}
