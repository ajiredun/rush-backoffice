<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class UserPasswordModifyCT extends AbstractContentType
{
    const CODE = "CT_USER_PASSWORD_MODIFY";

    public function getLabel()
    {
        return "User Modify Password Block";
    }

    public function getCategory()
    {
        return CTCategory::USER_ACCOUNT;
    }

}