<?php

namespace App\Controller;

use App\Entity\User;
use App\Enums\UserStatus;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // if ($this->getUser()) {
        //    $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $messageSuccess = '';
        if ($request->getSession()->has('rf.success.message')) {
            $messageSuccess =  $request->getSession()->get('rf.success.message', '');
            $request->getSession()->remove('rf.success.message');
        }

        $messageError = '';
        if ($request->getSession()->has('rf.error.message')) {
            $messageError =  $request->getSession()->get('rf.error.message', '');
            $request->getSession()->remove('rf.error.message');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'messageError' => $messageError,
            'messageSuccess' => $messageSuccess
        ]);
    }

    /**
     * @Route("/test", name="app_test")
     */
    public function test()
    {
        return new Response('<h1>Hello Test</h1>');
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserManager $userManager)
    {
        $error = null;

        if (
            $request->isMethod('POST')
        ) {
            if (
                $request->request->get('input_email') &&
                $request->request->get('input_firstname') &&
                $request->request->get('input_lastname') &&
                $request->request->get('input_password') &&
                $request->request->get('input_confirm_password')
            ) {
                if ($request->request->get('input_password') === $request->request->get('input_confirm_password')) {
                    $user = $userManager->createUser([
                        'firstname' => $request->request->get('input_firstname'),
                        'lastname' => $request->request->get('input_lastname'),
                        'email' => $request->request->get('input_email'),
                        'password' => $request->request->get('input_password'),
                    ]);

                } else {
                    $error = "The two passwords don't match.";
                }
            } else {
                $error = "Please fill in all the details";
            }
        }

        return $this->render('security/register.html.twig', [
            'error' => $error,
            'input_email' => $request->request->get('input_email'),
            'input_firstname' => $request->request->get('input_firstname'),
            'input_lastname' => $request->request->get('input_lastname')
        ]);
    }

    /**
     * @Route("/activate/{activation}", name="app_activate")
     */
    public function activate($activation, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(array('activation'=>$activation));

        if ($user) {
            $user->setActivation(null);
            $user->setStatus(UserStatus::ACTIVE);
            $entityManager->flush();

            $request->getSession()->set(
                'rf.success.message',
                'Your account has been activated successfully.'
            );
        } else {
            $request->getSession()->set(
                'rf.error.message',
                'Invalid activation link'
            );
        }
        return new RedirectResponse($this->generateUrl('rf_dashboard'));
    }

    /**
     * @Route("/forgot-password", name="app_forgot_password")
     */
    public function forgotPassword(Request $request, UserManager $userManager)
    {
        $error = null;

        if ($request->isMethod('POST')) {
            if (!empty($request->request->get('input_email'))) {
                $email = $request->request->get('input_email');
                $ur = $this->getDoctrine()->getRepository(User::class);
                $user = $ur->findOneBy(array('email'=>$email));
                if ($user) {
                    $userManager->setPassword($user);
                    $this->getDoctrine()->getManager()->flush();

                    $error = "We sent you an Email.";
                } else {
                    $error = "There is no account with this email address.";
                }
            } else {
                $error = "Please enter the recovery email address.";
            }
        }

        return $this->render('security/forgotPassword.html.twig', ['error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
