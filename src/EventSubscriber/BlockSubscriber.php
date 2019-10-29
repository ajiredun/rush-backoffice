<?php


namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Block;
use App\Service\BlockManager;
use App\Service\ObjectRelationManager;
use App\Service\RfMessages;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class BlockSubscriber implements EventSubscriberInterface
{

    protected $security;
    protected $em;
    protected $rfMessages;
    protected $blockManager;
    protected $objectRelationManager;

    public function __construct(
        EntityManagerInterface $em,
        Security $security,
        RfMessages $rfMessages,
        BlockManager $blockManager,
        ObjectRelationManager $objectRelationManager
    ){
        $this->security = $security;
        $this->em = $em;
        $this->rfMessages = $rfMessages;
        $this->blockManager = $blockManager;
        $this->objectRelationManager = $objectRelationManager;
    }

    public static function getSubscribedEvents()
    {

        return [
            KernelEvents::VIEW => ['transformData', EventPriorities::PRE_SERIALIZE],
        ];
    }

    public function transformData(ViewEvent $event)
    {
        /**
         * @var Block $block
         */
        $block = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$block instanceof Block || Request::METHOD_GET !== $method) {
            return;
        }

        $data = $block->getProperties();

        $this->objectRelationManager->tansformRelationsBeforePost($block, $data);
        $block->setProperties($data);
    }

}