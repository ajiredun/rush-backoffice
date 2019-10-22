<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class UserLoginCT extends AbstractContentType
{
    const CODE = "CT_USER_LOGIN";

    public function getLabel()
    {
        return "User Login Form";
    }

    public function getCategory()
    {
        return CTCategory::USER_ACCOUNT;
    }
}