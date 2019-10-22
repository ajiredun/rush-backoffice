<?php


namespace App\Service;


use App\Entity\User;

class MailManager
{
    const SYSTEM_EMAIL = 'dev@dev.ajiredun.com';

    protected $mailer;
    private $templating;
    protected $rfMessages;
    protected $systemManager;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, RfMessages $rfMessages, SystemManager $systemManager)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->rfMessages = $rfMessages;
        $this->systemManager = $systemManager;
    }

    /**
     * @return SystemManager
     */
    public function getSystemManager(): SystemManager
    {
        return $this->systemManager;
    }

    /**
     * @param SystemManager $systemManager
     */
    public function setSystemManager(SystemManager $systemManager): void
    {
        $this->systemManager = $systemManager;
    }


    public function sendActivationMail(User $user, $frontOffice)
    {
        if (!$frontOffice) {
            $message = (new \Swift_Message('Rush Framework - Activation'))
                ->setFrom(MailManager::SYSTEM_EMAIL)
                ->setTo($user->getEmail())
                ->setBody(
                    $this->templating->render(
                    // templates/emails/registration.html.twig
                        'Email/User/activation.html.twig',
                        ['user' => $user, 'frontOffice' => false]
                    ),
                    'text/html'
                )
            ;
        } else {
            $message = (new \Swift_Message( $this->getSystemManager()->getValue('fo_name') .' - Activation'))
                ->setFrom($this->getSystemManager()->getValue('management_email'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->templating->render(
                    // templates/emails/registration.html.twig
                        'Email/User/activation.html.twig',
                        ['user' => $user, 'frontOffice' => true]
                    ),
                    'text/html'
                )
            ;
        }

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