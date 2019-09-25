<?php

namespace App\Twig;

use App\Entity\User;
use App\Enums\LayoutCode;
use App\Enums\Roles;
use App\Enums\UserStatus;
use App\Repository\VisualPackRepository;
use App\Service\SearchParams;
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
     * AppExtension constructor.
     * @param SearchParams $searchParams
     */
    public function __construct(SearchParams $searchParams,VisualPackRepository $visualPackRepository)
    {
        $this->searchParams = $searchParams;
        $this->visualPackRepository = $visualPackRepository;
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
        ];
    }

    public function getSystemFormMethod()
    {
        return "post";
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