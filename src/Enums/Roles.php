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

    // ROLE MANAGEMENT
    const ROLE_ROLES_MANAGEMENT = "ROLE_ROLES_MANAGEMENT";

    //MEDIA MANAGEMENT
    const ROLE_MEDIA_MANAGEMENT_VIEWER = "ROLE_MEDIA_MANAGEMENT_VIEWER";
    const ROLE_MEDIA_MANAGEMENT_EDITOR = "ROLE_MEDIA_MANAGEMENT_EDITOR";

    //MEDIA MANAGEMENT
    const ROLE_VISUAL_PACK_VIEWER = "ROLE_VISUAL_PACK_VIEWER";
    const ROLE_VISUAL_PACK_EDITOR = "ROLE_VISUAL_PACK_EDITOR";

    //PAGE MANAGEMENT
    const ROLE_PAGE_MANAGEMENT_VIEWER = "ROLE_PAGE_MANAGEMENT_VIEWER";
    const ROLE_PAGE_MANAGEMENT_EDITOR = "ROLE_PAGE_MANAGEMENT_EDITOR";


    static function getLabel($role)
    {
        $list = Roles::getList();
        if (array_key_exists($role, $list)) {
            return $list[$role];
        }
        return '';
    }

    static function roleExist($role)
    {
        $list = Roles::getList();
        if (array_key_exists($role, $list)) {
            return true;
        }
        return false;
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
            Roles::ROLE_ROLES_MANAGEMENT => "Role Manager",
            Roles::ROLE_VISUAL_PACK_VIEWER => "Visual Pack Manager - View Only",
            Roles::ROLE_VISUAL_PACK_EDITOR => "Visual Pack Manager",
            Roles::ROLE_PAGE_MANAGEMENT_VIEWER => "Page Manager - View Only",
            Roles::ROLE_PAGE_MANAGEMENT_EDITOR => "Page Manager"
        ];
    }

    static function getConfigurableList()
    {
        return [
            Roles::ROLE_ADMIN => "Admin" ,
            Roles::ROLE_VIEWER => 'Back Office User',
            Roles::ROLE_USER_MANAGEMENT_EDITOR => "User Manager",
            Roles::ROLE_MEDIA_MANAGEMENT_EDITOR => "Media Manager",
            Roles::ROLE_ROLES_MANAGEMENT => "Role Manager",
            Roles::ROLE_VISUAL_PACK_EDITOR => "Visual Pack Manager",
            Roles::ROLE_PAGE_MANAGEMENT_EDITOR => "Page Manager"
        ];
    }

    static function getFOList()
    {
        return [
            Roles::ROLE_USER => 'Website User'
        ];
    }
}