<?php

namespace App\Service;


use App\Entity\Block;
use App\Entity\ObjectRelation;
use Doctrine\ORM\EntityManagerInterface;

class ObjectRelationManager
{
    /**
     * @var BlockManager $blockManager
     */
    protected $blockManager;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * ObjectRelationManager constructor.
     * @param BlockManager $blockManager
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(BlockManager $blockManager, EntityManagerInterface $entityManager)
    {
        $this->blockManager = $blockManager;
        $this->entityManager = $entityManager;
    }

    public function tansformRelationsAfterPost(Block $block, array &$data)
    {
        if ($this->hasObjectRelationMeta($block)) {
            $relationMeta = $this->getObjectRelationsMeta($block);
            foreach ($relationMeta as $meta) {
                if (array_key_exists($meta['formName'],$data)) {

                    $object =  $data[$meta['formName']];
                    if (!empty($object)) {
                        $id = $object->getId();
                        //$object = $this->entityManager->getRepository($meta['type'])->find($id);
                        //dd($data, $object);
                        $data[$meta['formName']] = $id;
                    }


                }
            }
        }
    }

    public function tansformRelationsBeforePost(Block $block, array &$data)
    {
        if ($this->hasObjectRelationMeta($block)) {
            $relationMeta = $this->getObjectRelationsMeta($block);
            foreach ($relationMeta as $meta) {
                if (array_key_exists($meta['formName'],$data)) {
                    $id = $data[$meta['formName']];
                    if (!empty($id)) {
                        $object = $this->entityManager->getRepository($meta['type'])->find($id);
                        $data[$meta['formName']] = $object;
                    }
                }
            }
        }
    }

    public function addObjectRelationIfExist(Block $block)
    {
        if ($this->hasObjectRelationMeta($block)) {
            $relationMeta = $this->getObjectRelationsMeta($block);
            $data = $block->getProperties();
            foreach ($relationMeta as $meta) {
                if (array_key_exists($meta['formName'],$data)) {
                    $id = $data[$meta['formName']];
                    //we create a new ObjectRelation
                    $or = new ObjectRelation();
                    $or->setBlock($block);
                    $or->setObjectId($id);
                    $or->setType($meta['type']);

                    $this->entityManager->persist($or);
                }
            }

            $this->entityManager->flush();
        }
    }


    public function transformForUrl(array $relations)
    {
        $relationIds = [];
        foreach ($relations as $relation) {

            $relationIds[] = $relation->getId();
        }

        return implode(',',$relationIds);
    }

    public function transformFromUrl(string $ids)
    {
        $relations = [];
        $relationIds = explode(',', $ids);
        foreach ($relationIds as $id) {
            $relations[] = $this->entityManager->getRepository(ObjectRelation::class)->find($id);
        }

        return $relations;
    }

    public function objectHasRelation($type, $id)
    {
        $ors = $this->entityManager->getRepository(ObjectRelation::class)->findBy(
            [
                'type' => $type,
                'objectId' => $id
            ]
        );

        if (empty($ors)) {
            return false;
        }

        return $ors;
    }


    public function handleRelations(Block $block, array $data)
    {
        if ($this->hasObjectRelationMeta($block)) {

            $this->removeObjectRelations($block);

            $relationMeta = $this->getObjectRelationsMeta($block);
            foreach ($relationMeta as $meta) {
                if (array_key_exists($meta['formName'],$data)) {
                    $id = $data[$meta['formName']];
                        //we create a new ObjectRelation
                        $or = new ObjectRelation();
                        $or->setBlock($block);
                        $or->setObjectId($id);
                        $or->setType($meta['type']);

                        $this->entityManager->persist($or);
                }
            }

            $this->entityManager->flush();
        }
    }

    public function hasObjectRelationMeta(Block $block)
    {
        $relations = $this->blockManager->getContentType($block)->getObjectRelation();

        if (!is_null($relations)) {
            return true;
        }

        return false;
    }


    public function getObjectRelationsMeta(Block $block)
    {
        return $this->blockManager->getContentType($block)->getObjectRelation();
    }

    public function removeObjectRelations(Block $block)
    {
        $ors = $this->entityManager->getRepository(ObjectRelation::class)->findBy(
            [
                'block' => $block
            ]
        );

        if (!empty($ors)) {
            foreach ($ors as $or)
            {
                $this->entityManager->remove($or);
            }
            $this->entityManager->flush();
        }
    }


    /**
     * @return BlockManager
     */
    public function getBlockManager(): BlockManager
    {
        return $this->blockManager;
    }

    /**
     * @param BlockManager $blockManager
     */
    public function setBlockManager(BlockManager $blockManager): void
    {
        $this->blockManager = $blockManager;
    }

}