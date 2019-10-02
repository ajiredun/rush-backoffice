<?php


namespace App\Enums;


class CTProperty
{
    const DEPENDENCIES = 'dependencies';

    static function getList()
    {
        return [
            CTProperty::DEPENDENCIES => 'List of dependent blocks',
        ];
    }


}