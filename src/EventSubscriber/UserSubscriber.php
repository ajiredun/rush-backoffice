<?php


namespace App\EventSubscriber;


use App\Event\UserCreateEvent;
use App\Event\UserPasswordEvent;
use App\Service\MailManager;
use App\Util\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    protected $mailManager;

    public function __construct(MailManager $mailManager)
    {
        $this->mailManager = $mailManager;
    }


    public static function getSubscribedEvents()
    {
        return [
            UserCreateEvent::NAME => [
                ['userCreate_activation_link',10],
                ['userCreate_activation_mail',9],
            ],

            UserPasswordEvent::NAME => [
                ['userPassword_change',10],
            ],
        ];
    }


    public function userCreate_activation_link(UserCreateEvent $event)
    {

        $user = $event->getUser();
        $user->setActivation(Security::createActivationLink($user));
    }

    public function userCreate_activation_mail(UserCreateEvent $event)
    {
        $this->mailManager->sendActivationMail($event->getUser());

    }

    public function userPassword_change(UserPasswordEvent $event)
    {

    }
}