<?php

namespace App\Twig;

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
            new TwigFunction('area', [$this, 'calculateArea']),
        ];
    }

    public function roleLabel($role)
    {
        return Roles::getLabel($role);
    }

    public function calculateArea(int $width, int $length)
    {
        return $width * $length;
    }
}