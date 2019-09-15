<?php


namespace App\Enums;


class UserStatus
{
    const INACTIVE = 'inactive';
    const ACTIVE = 'active';
    const BLOCKED = 'blocked';
    const ARCHIVED = 'archived';

    static function getStatus($statusFrom)
    {
        $enums = UserStatus::getArray();

        if (array_key_exists($statusFrom,$enums)) {
            return $enums[$statusFrom];
        } else {
            return 'archived';
        }
    }

    static function getArray()
    {
        return [
            UserStatus::INACTIVE,
            UserStatus::ACTIVE,
            UserStatus::BLOCKED,
            UserStatus::ARCHIVED
        ];
    }


}