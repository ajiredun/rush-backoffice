<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class UserActivateAccountCT extends AbstractContentType
{
    const CODE = "CT_USER_ACTIVATE_ACCOUNT";

    public function getLabel()
    {
        return "User Activation Block";
    }

    public function getCategory()
    {
        return CTCategory::USER_ACCOUNT;
    }

}