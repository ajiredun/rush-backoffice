<?php


namespace App\Enums;


class Boolean
{
    const TRUE = true;
    const FALSE = false;

    public static function getChoices()
    {
        return [
            'TRUE' => true,
            'FALSE' => false
        ];
    }
}