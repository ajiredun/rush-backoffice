<?php


namespace App\Enums;


class CTCategory
{
    const MENU = 'menu';
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
            CTCategory::DEFAULT => 'Default'
        ];
    }

    static function getList()
    {
        return [
            CTCategory::MENU => [
                'label'=> CTCategory::getLabel(CTCategory::MENU),
                'list' => []
            ],
            CTCategory::DEFAULT =>  [
                'label'=> CTCategory::getLabel(CTCategory::DEFAULT),
                'list' => []
            ],
        ];
    }
}