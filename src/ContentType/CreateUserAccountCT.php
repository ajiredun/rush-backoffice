<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class CreateUserAccountCT extends AbstractContentType
{
    const CODE = "CT_CREATE_USER_ACCOUNT";

    public function getLabel()
    {
        return "Create User Account";
    }

    public function getCategory()
    {
        return CTCategory::USER_ACCOUNT;
    }

}