<?php

namespace App\Twig;

use App\Entity\User;
use App\Enums\Roles;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
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
}