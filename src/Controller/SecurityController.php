<?php

namespace App\Controller;

use App\Entity\ApiToken;
use App\Entity\User;
use App\Enums\Roles;
use App\Enums\UserStatus;
use App\Service\RfMessages;
use App\Service\UserManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {

        if ($accessDenied = $request->attributes->get(Security::ACCESS_DENIED_ERROR, false)) {
            if ($accessDenied instanceof AccessDeniedException && !is_null($accessDenied->getSubject()) && $accessDenied->getSubject()->attributes->get('_route', false)) {
                return new JsonResponse(
                    [
                        'message' => 'Access Denied!'
                    ],
                    403
                );
            }

            if ($accessDenied instanceof AccessDeniedException && !is_null($accessDenied->getMessage()) && $accessDenied->getMessage()=="UNAUTHORISED_API_REQUEST") {
                return new JsonResponse(
                    [
                        'message' => 'Access Denied!'
                    ],
                    403
                );
            }
        }

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
     * @Route("/api/login", name="app_api_login")
     */
    public function apiLogin(Request $request, UserManager $userManager): Response
    {
        $errorMessage = "Authentication error";
        $errorMessage = $request->request->all();
        if (
            $request->isMethod('POST') &&
            $request->request->get('email', false) &&
            $request->request->get('password', false)
        ) {
            $username = $request->request->get('email', false);
            $password = $request->request->get('password', false);

            $user = $userManager->getUserByEmail($username);
            if ($user) {
                $isPasswordMatched = $userManager->verifyPassword($user, $password);
                if ($isPasswordMatched) {
                    /**
                     * @var ApiToken $apiToken
                     */
                    $apiToken = $userManager->generateToken($user);
                    return new JsonResponse(
                        [
                            'message' => "Authentification Successful",
                            'success' => true,
                            'user' => $user->getName(),
                            'email' => $user->getEmail(),
                            'token' => $apiToken->getToken(),
                            'roles' => $user->getRoles(),
                            'user_id' => $user->getId(),
                            'user_name' => $user->getName()
                        ],
                        200
                    );
                } else {
                    $errorMessage = "Invalid credentials.";
                }
            } else {
                $errorMessage = "No user was found with this email.";
            }

        }

        return new JsonResponse(
            [
                'message' => $errorMessage,
                'success' => false
            ],
            200
        );
    }

    /**
     * @Route("/api/logout", name="app_api_logout")
     */
    public function apiLogout(Request $request, TokenStorageInterface $tokenStorage, UserManager $userManager, EntityManagerInterface $entityManager): Response
    {
        $errorMessage = "There was no active session.";
        if ($this->getUser()) {

            $apiToken = $userManager->getActiveApiToken($this->getUser());

            if (!is_null($apiToken)) {
                $apiToken->setExpiresAt(new \DateTime('now'));
                $entityManager->flush();

                $anonToken = new AnonymousToken('50cdf89882454', 'anon.', array());
                $tokenStorage->setToken($anonToken);

                return new JsonResponse(
                    [
                        'message' => "Logged out!",
                    ],
                    200
                );
            }
        }

        return new JsonResponse(
            [
                'message' => $errorMessage,
            ],
            200
        );
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
        $success = null;

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

                    $email = $request->request->get('input_email');

                    if (!$userManager->isUserExist($email)) {
                        $user = $userManager->createUser([
                            'firstname' => $request->request->get('input_firstname'),
                            'lastname' => $request->request->get('input_lastname'),
                            'email' => $email,
                            'password' => $request->request->get('input_password'),
                        ], []);

                        $success = "Please activate your account by clicking on the link we sent by mail.";
                    } else {
                        $error = "An account with this email address already exists.";
                    }
                } else {
                    $error = "The two passwords don't match.";
                }
            } else {
                $error = "Please fill in all the details";
            }
        }

        return $this->render('security/register.html.twig', [
            'error' => $error,
            'success' => $success,
            'input_email' => $request->request->get('input_email'),
            'input_firstname' => $request->request->get('input_firstname'),
            'input_lastname' => $request->request->get('input_lastname')
        ]);
    }

    /**
     * @Route("/api/register", name="api_register")
     */
    public function apiRegister(Request $request, UserManager $userManager, RfMessages $rfMessages)
    {

        $response = [
            'success' => false,
            'message' => ''
        ];

        if (
        $request->isMethod('POST')
        ) {
            $contents = json_decode($request->getContent(), true);


            $response['input'] = $contents;

            if (!empty($contents)) {
                if (
                    (isset($contents['input_email']) && !empty($contents['input_email'])) &&
                    (isset($contents['input_firstname']) && !empty($contents['input_firstname'])) &&
                    (isset($contents['input_lastname']) && !empty($contents['input_lastname'])) &&
                    (isset($contents['input_password']) && !empty($contents['input_password'])) &&
                    (isset($contents['input_confirm_password']) && !empty($contents['input_confirm_password'])) &&
                    (isset($contents['input_mobile']) && !empty($contents['input_mobile']))
                ) {
                    if ($contents['input_password'] === $contents['input_confirm_password']) {
                        $email = $contents['input_email'];
                        if (!$userManager->isUserExist($email)) {
                            $user = $userManager->createUserFromWebsite([
                                'firstname' => $contents['input_firstname'],
                                'lastname' => $contents['input_lastname'],
                                'email' => $email,
                                'password' => $contents['input_password']
                            ], []);

                            $warnings = $rfMessages->getMessages()['rfwarning'];
                            if (!empty($warnings)) {
                                $response['message'] = $warnings[0];
                            } else {
                                $response['success'] = true;
                                $response['message'] = "Please activate your account by clicking on the link we sent by mail.";
                            }

                        } else {
                            $response['message'] = "An account with this email address already exists.";
                        }

                    } else {
                        $response['message'] = "The two passwords don't match.";
                    }
                } else {
                    $response['message'] = "Please fill in all the details";
                }
            } else {
                $response['message'] = "Invalid information";
            }
        }

        return new JsonResponse($response);
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
     * @Route("/api/activate/{activation}", name="api_activate")
     */
    public function apiActivate($activation, Request $request)
    {

        $response = [
            'success' => false,
            'message' => ''
        ];

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(array('activation'=>$activation));

        if ($user) {
            $user->setActivation(null);
            $user->setStatus(UserStatus::ACTIVE);
            $entityManager->flush();

            $response['success'] = true;
            $response['message'] = 'Your account has been activated successfully.';
        } else {
            $response['message'] = 'Invalid activation link';
        }

        return new JsonResponse($response);
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
