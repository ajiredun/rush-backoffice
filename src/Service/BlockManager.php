<?php
namespace App\Service;


use App\Entity\Block;
use App\Entity\Page;
use App\Repository\BlockRepository;

class BlockManager
{
    /**
     * @var BlockRepository
     */
    protected $blockRepository;

    public function __construct(BlockRepository $blockRepository)
    {
        $this->blockRepository = $blockRepository;
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

}