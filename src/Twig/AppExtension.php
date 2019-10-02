<?php

namespace App\Twig;

use App\Entity\Page;
use App\Entity\User;
use App\Enums\LayoutCode;
use App\Enums\Roles;
use App\Enums\UserStatus;
use App\Repository\VisualPackRepository;
use App\Service\CTManager;
use App\Service\PageManager;
use App\Service\SearchParams;
use App\Service\SystemManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    /**
     * @var SearchParams
     */
    protected  $searchParams;

    /**
     * @var VisualPackRepository
     */
    protected  $visualPackRepository;

    /**
     * @var SystemManager
     */
    protected $systemManager;

    /**
     * @var PageManager
     */
    protected $pageManager;

    /**
     * @var CTManager
     */
    protected $CTManager;

    /**
     * AppExtension constructor.
     * @param SearchParams $searchParams
     * @param VisualPackRepository $visualPackRepository
     * @param SystemManager $systemManager
     * @param PageManager $pageManager
     * @param CTManager $CTManager
     */
    public function __construct(
        SearchParams $searchParams,
        VisualPackRepository $visualPackRepository,
        SystemManager $systemManager,
        PageManager $pageManager,
        CTManager $CTManager
    ){
        $this->searchParams = $searchParams;
        $this->visualPackRepository = $visualPackRepository;
        $this->systemManager = $systemManager;
        $this->pageManager = $pageManager;
        $this->CTManager = $CTManager;
    }


    public function getFilters()
    {
        return [
            new TwigFilter('roleLabel', [$this, 'roleLabel']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getConfigurableRoles', [$this, 'getConfigurableRoles']),
            new TwigFunction('getUserStatusList', [$this, 'getUserStatusList']),
            new TwigFunction('searchParamsGet', [$this, 'searchParamsGet']),
            new TwigFunction('getLayoutList', [$this, 'getLayoutList']),
            new TwigFunction('getConfigurableFORoles', [$this, 'getConfigurableFORoles']),
            new TwigFunction('getCurrentVisualPack', [$this, 'getCurrentVisualPack']),
            new TwigFunction('getSystemFormMethod', [$this, 'getSystemFormMethod']),
            new TwigFunction('getSystemInfo', [$this, 'getSystemInfo']),
            new TwigFunction('getDraftPageOfPublishedPage', [$this, 'getDraftPageOfPublishedPage']),
            new TwigFunction('getPublishedPageOfDraftPage', [$this, 'getPublishedPageOfDraftPage']),
            new TwigFunction('get_blocks_for_slot', [$this, 'get_blocks_for_slot']),
            new TwigFunction('getContentTypeByCode', [$this, 'getContentTypeByCode']),
        ];
    }


    public function getContentTypeByCode($code)
    {
        return $this->CTManager->getContentTypeByCode($code);
    }

    public function get_blocks_for_slot(array $blocks, $slot)
    {
        if (array_key_exists($slot, $blocks)) {
            return $blocks[$slot];
        } else {
            return false;
        }
    }

    public function getDraftPageOfPublishedPage($page)
    {
        if ($page instanceof Page) {
            return $this->pageManager->getDraftPageByPublishedPage($page);
        } else {
            return $this->pageManager->getDraftPageByPublishedPageId($page);
        }
    }

    public function getPublishedPageOfDraftPage($page)
    {
        if ($page instanceof Page) {
            return $this->pageManager->getPublishedPageByDraftPage($page);
        } else {
            return $this->pageManager->getPublishedPageByDraftPageId($page);
        }
    }

    public function getSystemFormMethod()
    {
        return $this->systemManager->getValue('form_list_method');
    }

    public function getSystemInfo($term)
    {
        return $this->systemManager->getValue($term);
    }

    public function getCurrentVisualPack()
    {
        return $this->visualPackRepository->findOneBy(['active'=>true]);
    }

    public function roleLabel($role)
    {
        return Roles::getLabel($role);
    }

    public function getConfigurableRoles()
    {
        return Roles::getConfigurableList();
    }

    public function getConfigurableFORoles()
    {
        return Roles::getFOList();
    }

    public function searchParamsGet($sector, $param = null)
    {
        return $this->searchParams->get($sector, $param);
    }

    public function getUserStatusList()
    {
        return UserStatus::getList();
    }

    public function getLayoutList()
    {
        return LayoutCode::getList();
    }
}