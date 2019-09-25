<?php

namespace App\Service;


use App\Entity\Layout;
use Doctrine\ORM\EntityManagerInterface;

class LayoutManager
{
    protected $entityManager;

    /**
     * LayoutManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getLayoutById($id)
    {
        return $this->getLayoutRepository()->find($id);
    }

    public function getLayoutRepository()
    {
        return $this->entityManager->getRepository(Layout::class);
    }

}