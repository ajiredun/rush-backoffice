<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class UserPasswordForgetCT extends AbstractContentType
{
    const CODE = "CT_USER_PASSWORD_FORGET";

    public function getLabel()
    {
        return "User Forget Password Block";
    }

    public function getCategory()
    {
        return CTCategory::USER_ACCOUNT;
    }

}