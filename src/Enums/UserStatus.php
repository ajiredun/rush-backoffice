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

        if (in_array($statusFrom,$enums)) {
            return $statusFrom;
        } else {
            return false;
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

    static function getList()
    {
        return [
            UserStatus::INACTIVE => 'Inactive',
            UserStatus::ACTIVE => 'Active',
            UserStatus::BLOCKED => 'Blocked',
            UserStatus::ARCHIVED => 'Archived'
        ];
    }


}