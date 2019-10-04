<?php


namespace App\Enums;


class CTCategory
{
    const MENU = 'menu';
    const BASIC = 'basic';
    const DEFAULT = 'default';

    static function getLabel($value)
    {
        $labels = CTCategory::getLabels();
        if (array_key_exists($value, $labels)) {
            return $labels[$value];
        }

        return null;
    }

    static function getLabels()
    {
        return [
            CTCategory::MENU => 'Menus',
            CTCategory::BASIC => 'Basic',
            CTCategory::DEFAULT => 'Default'
        ];
    }

    static function getList()
    {
        $array = [];

        foreach (CTCategory::getLabels() as $category=>$label)
        {
            $array[$category] = ['label'=>$label, 'list'=>[]];
        }


        return $array;
    }
}