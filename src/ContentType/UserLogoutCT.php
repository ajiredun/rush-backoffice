<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class UserLogoutCT extends AbstractContentType
{
    const CODE = "CT_USER_LOGOUT";

    public function getLabel()
    {
        return "User Logout Block";
    }

    public function getCategory()
    {
        return CTCategory::USER_ACCOUNT;
    }
    
}