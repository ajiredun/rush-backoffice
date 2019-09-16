<?php


namespace App\Service;


use App\Entity\User;

class MailManager
{
    const EMAIL = 'ajir.edun@gmail.com';
    const SYSTEM_EMAIL = 'dev@dev.ajiredun.com';

    protected $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }


    public function sendActivationMail(User $user)
    {
        $message = (new \Swift_Message('Rush Framework - Activation'))
            ->setFrom(MailManager::SYSTEM_EMAIL)
            ->setTo(MailManager::EMAIL)
            ->setBody(
                $this->templating->render(
                // templates/emails/registration.html.twig
                    'Email/User/activation.html.twig',
                    ['user' => $user]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }

    public function sendForgotPasswordMail(User $user, $password)
    {
        $message = (new \Swift_Message('Rush Framework - Forgot Password'))
            ->setFrom(MailManager::SYSTEM_EMAIL)
            ->setTo(MailManager::EMAIL)
            ->setBody(
                $this->templating->render(
                // templates/emails/registration.html.twig
                    'Email/User/password.html.twig',
                    ['user' => $user, 'password' => $password]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}