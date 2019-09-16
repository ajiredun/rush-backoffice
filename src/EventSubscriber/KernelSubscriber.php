<?php


namespace App\EventSubscriber;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class KernelSubscriber implements EventSubscriberInterface
{

    protected $user;
    protected $em;

    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->user = $security->getUser();
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
        if ($event->isMasterRequest()) {
            if (!is_null($this->user)) {
                dd();
            }
        }
        if (!$this->user->isActiveNow()) {
            $this->user->setLastActive(new \DateTime());
            $this->em->flush($this->user);
        }
    }
}