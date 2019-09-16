<?php


namespace App\EventSubscriber;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class KernelSubscriber implements EventSubscriberInterface
{

    protected $security;
    protected $em;

    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->security = $security;
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::TERMINATE => [
                ['onTerminate',20]
            ],
        ];
    }

    public function onTerminate(KernelEvent $event)
    {
        $user = $this->security->getUser();

        if (!is_null($user) && !$user->isActiveNow()) {
            $user->setLastactive(new \DateTime());
            $this->em->flush($user);
        }
    }
}