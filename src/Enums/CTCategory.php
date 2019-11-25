<?php


namespace App\Enums;


class CTCategory
{
    const MENU = 'menu';
    const BASIC = 'basic';
    const DISPLAY = 'display';
    const DEFAULT = 'default';
    const SLIDER = 'slider';
    const USER_ACCOUNT = 'user_account';
    const CATEGORY = "category";

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
            CTCategory::DEFAULT => 'Default',
            CTCategory::SLIDER => 'Slider',
            CTCategory::DISPLAY => 'Display',
            CTCategory::USER_ACCOUNT => 'User Account',
            CTCategory::CATEGORY => 'Category'
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