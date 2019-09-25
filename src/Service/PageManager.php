<?php


namespace App\Service;


use App\Entity\Page;
use App\Entity\User;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PageManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var RfMessages
     */
    protected $rfMessages;

    /**
     * @var PageRepository
     */
    protected $pageRepository;

    /**
     * @var Security
     */
    protected $security;

    /**
     * PageManager constructor.
     * @param EntityManagerInterface $em
     * @param RfMessages $rfMessages
     * @param PageRepository $pageRepository
     */
    public function __construct(EntityManagerInterface $em, Security $security, RfMessages $rfMessages, PageRepository $pageRepository)
    {
        $this->em = $em;
        $this->rfMessages = $rfMessages;
        $this->pageRepository = $pageRepository;
        $this->security = $security;
    }

    public function createPage(Page $page)
    {
        //checking if there is already another page with the same route
        $route = $page->getRoute();
        if (!$this->isRouteValid($route)) {
            return false;
        }
        if (!$this->isRouteExist($route)) {
            //setting the layout
            $page->setLastModifiedBy($this->security->getUser());
            $this->getEntityManager()->persist($page);
            $this->getEntityManager()->flush();

            return $page;
        } else {
            $this->rfMessages->addError("The route: '$route' already exists.");
        }

        return false;
    }

    public function updatePage(Page $page)
    {
        //checking if there is already another page with the same route
        $route = $page->getRoute();
        if (!$this->isRouteValid($route)) {
            return false;
        }

        $page->setLastModifiedAt(new \DateTime('now'));
        $page->setLastModifiedBy($this->security->getUser());
        $this->getEntityManager()->flush();

        return $page;

    }


    public function getDraftPageByPublishedPage(Page $pagePublished)
    {
        if ($pagePublished) {
            $routePublished = $pagePublished->getRoute();
            return $this->getDraftPageByRoute($routePublished);
        }

        return false;
    }

    public function getDraftPageByPublishedPageId($id)
    {
        $pagePublished = $this->pageRepository->find($id);
        if ($pagePublished) {
            $routePublished = $pagePublished->getRoute();
            return $this->getDraftPageByRoute($routePublished);
        }

        return false;
    }

    public function getDraftPageByRoute($route)
    {
        if ($this->isRouteValid($route)) {
            $page = $this->pageRepository->findOneBy(
                ['route' => $route, 'published' => false]
            );
            if ($page) {
                return $page;
            }
        }

        return false;
    }

    public function getPublishedPage($route)
    {
        if ($this->isRouteValid($route)) {
            $page = $this->pageRepository->findOneBy(
                ['route' => $route, 'published' => true]
            );
            if ($page) {
                return $page;
            }
        }

        return false;
    }


    public function isRoutePublished($route)
    {
        if ($this->isRouteValid($route)) {
            $list = $this->pageRepository->findBy(
                ['route' => $route, 'published' => true]
            );
            if (!empty($list)) {
                return true;
            } else {
                $this->getRfMessages()->addError("There is no published version for '$route'");
            }
        }

        return false;
    }

    public function isRouteExist($route)
    {
        $list = $this->pageRepository->findBy(
            ['route' => $route]
        );

        if (!empty($list)) {
            return true;
        }

        return false;
    }

    public function isRouteValid($route)
    {

        //Rule 1 - Must start with a slash
        if ("/" === substr($route, 0, 1)) {
            return true;
        } else {
            $this->getRfMessages()->addError("The route should start with a '/'");
        }

        return false;
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

    /**
     * @return RfMessages
     */
    public function getRfMessages(): RfMessages
    {
        return $this->rfMessages;
    }

    /**
     * @param RfMessages $rfMessages
     */
    public function setRfMessages(RfMessages $rfMessages): void
    {
        $this->rfMessages = $rfMessages;
    }

}