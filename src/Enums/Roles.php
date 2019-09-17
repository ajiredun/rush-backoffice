<?php


namespace App\Enums;


class Roles
{
    //BASIC
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    const ROLE_VIEWER = 'ROLE_VIEWER';

    // USER MANAGEMENT
    const ROLE_USER_MANAGEMENT_VIEWER = "ROLE_USER_MANAGEMENT_VIEWER";
    const ROLE_USER_MANAGEMENT_EDITOR = "ROLE_USER_MANAGEMENT_EDITOR";

    //MEDIA MANAGEMENT
    const ROLE_MEDIA_MANAGEMENT_VIEWER = "ROLE_MEDIA_MANAGEMENT_VIEWER";
    const ROLE_MEDIA_MANAGEMENT_EDITOR = "ROLE_MEDIA_MANAGEMENT_EDITOR";


    static function getLabel($role)
    {
        $list = Roles::getList();
        if (array_key_exists($role, $list)) {
            return $list[$role];
        }
        return '';
    }

    static function getList()
    {
        return [
            Roles::ROLE_ADMIN => "Admin" ,
            Roles::ROLE_USER => 'Website User',
            Roles::ROLE_VIEWER => 'Back Office User',
            Roles::ROLE_USER_MANAGEMENT_VIEWER => "User Manager - View Only",
            Roles::ROLE_USER_MANAGEMENT_EDITOR => "User Manager",
            Roles::ROLE_MEDIA_MANAGEMENT_VIEWER => "Media Manager - View Only",
            Roles::ROLE_MEDIA_MANAGEMENT_EDITOR => "Media Manager",
        ];
    }
}