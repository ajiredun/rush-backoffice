<?php


namespace App\Service;


use App\Entity\User;

class MailManager
{

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
            ->setFrom('dev@dev.ajiredun.com')
            ->setTo('dev@dev.ajiredun.com')
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
}