<?php

namespace App\Twig;

use App\Entity\Page;
use App\Entity\User;
use App\Enums\LayoutCode;
use App\Enums\Roles;
use App\Enums\UserStatus;
use App\Repository\VisualPackRepository;
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
     * AppExtension constructor.
     * @param SearchParams $searchParams
     * @param VisualPackRepository $visualPackRepository
     * @param SystemManager $systemManager
     * @param PageManager $pageManager
     */
    public function __construct(
        SearchParams $searchParams,
        VisualPackRepository $visualPackRepository,
        SystemManager $systemManager,
        PageManager $pageManager
    ){
        $this->searchParams = $searchParams;
        $this->visualPackRepository = $visualPackRepository;
        $this->systemManager = $systemManager;
        $this->pageManager = $pageManager;
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
        ];
    }



    public function getDraftPageOfPublishedPage($page)
    {
        if ($page instanceof Page) {
            return $this->pageManager->getDraftPageByPublishedPage($page);
        } else {
            return $this->pageManager->getDraftPageByPublishedPageId($page);
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