<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class UserProfileWidgetCT extends AbstractContentType
{
    const CODE = "CT_USER_PROFILE_WIDGET";

    public function getLabel()
    {
        return "User Profile Widget";
    }

    public function getCategory()
    {
        return CTCategory::USER_ACCOUNT;
    }

}