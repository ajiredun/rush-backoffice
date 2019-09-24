<?php

namespace App\Twig;

use App\Entity\User;
use App\Enums\LayoutCode;
use App\Enums\Roles;
use App\Enums\UserStatus;
use App\Service\SearchParams;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    protected  $searchParams;

    /**
     * AppExtension constructor.
     * @param SearchParams $searchParams
     */
    public function __construct(SearchParams $searchParams)
    {
        $this->searchParams = $searchParams;
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
        ];
    }

    public function roleLabel($role)
    {
        return Roles::getLabel($role);
    }

    public function getConfigurableRoles()
    {
        return Roles::getConfigurableList();
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