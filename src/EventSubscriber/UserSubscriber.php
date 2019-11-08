<?php


namespace App\EventSubscriber;


use App\Enums\UserStatus;
use App\Event\UserCreateEvent;
use App\Event\UserPasswordEvent;
use App\Service\MailManager;
use App\Service\RfMessages;
use App\Service\SystemManager;
use App\Util\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    protected $mailManager;
    protected $rfMessages;
    protected $systemManager;


    public function __construct(MailManager $mailManager, RfMessages $rfMessages, SystemManager $systemManager)
    {
        $this->mailManager = $mailManager;
        $this->rfMessages = $rfMessages;
        $this->systemManager = $systemManager;
    }


    public static function getSubscribedEvents()
    {
        return [
            UserCreateEvent::NAME => [
                ['userCreate_activation_link',10],
                ['userCreate_activation_mail',9],
            ],

            UserPasswordEvent::NAME => [
                ['userPassword_mail',10],
            ],
        ];
    }


    public function userCreate_activation_link(UserCreateEvent $event)
    {

        $user = $event->getUser();
        if ($user->getStatus() == UserStatus::ACTIVE) {
            $this->rfMessages->addWarning('The user is already active, so we have not generated the activation link.');
            return;
        }
        $user->setActivation(Security::createActivationLink($user));
    }

    public function userCreate_activation_mail(UserCreateEvent $event)
    {
        $user = $event->getUser();
        if ($user->getStatus() == UserStatus::ACTIVE) {
            $this->rfMessages->addWarning('The user is already active, so we have not sent the activation mail.');
            return;
        }

        $this->mailManager->sendActivationMail($user, $event->isFrontOffice());

    }

    public function userPassword_mail(UserPasswordEvent $event)
    {
        $this->mailManager->sendForgotPasswordMail($event->getUser(), $event->getPassword(), $event->isFrontOffice());
    }
}