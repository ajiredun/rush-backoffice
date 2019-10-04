<?php
namespace App\Service;


use App\Entity\Block;
use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BlockRepository;
use Symfony\Component\Security\Core\Security;

class BlockManager
{
    /**
     * @var BlockRepository
     */
    protected $blockRepository;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var Security
     */
    protected $security;

    /**
     * @var CTManager
     */
    protected $CTManager;

    /**
     * BlockManager constructor.
     * @param EntityManagerInterface $em
     * @param Security $security
     * @param CTManager $CTManager
     * @param BlockRepository $blockRepository
     */
    public function __construct(EntityManagerInterface $em, Security $security, CTManager $CTManager, BlockRepository $blockRepository)
    {
        $this->em = $em;
        $this->security = $security;
        $this->CTManager = $CTManager;
        $this->blockRepository = $blockRepository;
    }


    /**
     * @param Block $block
     * @param array $params
     */
    public function updateBlock(Block $block,array $params)
    {
        if (isset($params['roles'])) {
            $block->setRoles($params['roles']);
        }

        if (isset($params['properties'])) {
            $block->setProperties($params['properties']);
        }

        $block->setLastModifiedAt(new \DateTime('now'));
        $block->setLastModifiedBy($this->security->getUser());
        $this->getEntityManager()->flush();
    }

    /**
     * @param Block $block
     * @return null
     */
    public function getPropertiesForm(Block $block)
    {
        $ct = $this->CTManager->getContentTypeByCode($block->getContentType());
        return $ct->getForm();
    }

    /**
     * @param Block $block
     * @return \App\ContentType\Base\AbstractContentType|null
     */
    public function getContentType(Block $block)
    {
        return $this->CTManager->getContentTypeByCode($block->getContentType());
    }

    public function getPageBlocks(Page $page)
    {
        return $this->blockRepository->findOrderedBlocks($page);
    }

    public function getPageBlocksBySlots(Page $page) : array
    {
        $blocks = $this->getPageBlocks($page);
        $slots = [];
        foreach ($blocks as $b) {
            /**
             * @var Block $b
             */
            if (array_key_exists($b->getSlot(),$slots)) {
                $slots[$b->getSlot()][] = $b;
            } else {
                $slots = array_merge($slots,[$b->getSlot()=>[$b]]);
            }
        }

        return $slots;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * @param EntityManagerInterface $em
     */
    public function setEntityManager(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

}