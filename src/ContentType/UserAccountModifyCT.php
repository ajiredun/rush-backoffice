<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class UserAccountModifyCT extends AbstractContentType
{
    const CODE = "CT_USER_ACCOUNT_MODIFY";

    public function getLabel()
    {
        return "User Modify Account Details Block";
    }

    public function getCategory()
    {
        return CTCategory::USER_ACCOUNT;
    }

}