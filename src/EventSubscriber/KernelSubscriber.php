<?php


namespace App\EventSubscriber;


use App\Service\RfMessages;
use App\Service\SearchParams;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class KernelSubscriber implements EventSubscriberInterface
{

    protected $security;
    protected $em;
    protected $rfMessages;
    protected $searchParams;

    public function __construct(EntityManagerInterface $em, Security $security, RfMessages $rfMessages, SearchParams $searchParams)
    {
        $this->security = $security;
        $this->em = $em;
        $this->rfMessages = $rfMessages;
        $this->searchParams = $searchParams;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => [
                ['onTerminate',20],
                ['onControllerInit']
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

    public function onControllerInit(KernelEvent $event)
    {
        $request = $event->getRequest();
        $this->manageRfMessage($request);
        $this->manageSearchParams($request);

    }

    protected function manageRfMessage($request)
    {
        if ($request->get('rfsuccess',false)) {
            if (is_array($request->get('rfsuccess'))) {
                foreach ($request->get('rfsuccess') as $message) {
                    $this->rfMessages->addSuccess($message);
                }
            } else {
                $this->rfMessages->addSuccess($request->get('rfsuccess'));
            }
        }

        if ($request->get('rfinfo',false)) {
            if (is_array($request->get('rfinfo'))) {
                foreach ($request->get('rfinfo') as $message) {
                    $this->rfMessages->addInfo($message);
                }
            } else {
                $this->rfMessages->addInfo($request->get('rfinfo'));
            }
        }

        if ($request->get('rfwarning',false)) {
            if (is_array($request->get('rfwarning'))) {
                foreach ($request->get('rfwarning') as $message) {
                    $this->rfMessages->addWarning($message);
                }
            } else {
                $this->rfMessages->addWarning($request->get('rfwarning'));
            }
        }

        if ($request->get('rferror',false)) {
            if (is_array($request->get('rferror'))) {
                foreach ($request->get('rferror') as $message) {
                    $this->rfMessages->addError($message);
                }
            } else {
                $this->rfMessages->addError($request->get('rferror'));
            }
        }
    }

    protected function manageSearchParams($request)
    {
        $params = array_merge($request->request->all(), $request->query->all());
        foreach ($params as $param => $paramvalue) {
            if (strpos($param, 'rfsearch_') !== false) {
                $split = explode('_',$param,2);
                $this->searchParams->add($split[1],$paramvalue);
            }
        }
    }
}