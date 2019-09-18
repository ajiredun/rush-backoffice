<?php


namespace App\Service;


use App\Entity\User;

class MailManager
{
    const SYSTEM_EMAIL = 'dev@dev.ajiredun.com';

    protected $mailer;
    private $templating;
    protected $rfMessages;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, RfMessages $rfMessages)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->rfMessages = $rfMessages;
    }


    public function sendActivationMail(User $user)
    {
        $message = (new \Swift_Message('Rush Framework - Activation'))
            ->setFrom(MailManager::SYSTEM_EMAIL)
            ->setTo($user->getEmail())
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
        $this->rfMessages->addInfo('Activation mail sent successfully.');
    }

    public function sendForgotPasswordMail(User $user, $password)
    {
        $message = (new \Swift_Message('Rush Framework - Forgot Password'))
            ->setFrom(MailManager::SYSTEM_EMAIL)
            ->setTo($user->getEmail())
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
        $this->rfMessages->addInfo('Forgot password mail sent successfully.');
    }
}