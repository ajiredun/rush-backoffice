<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class MediumDisplayCT extends AbstractContentType
{

    const CODE = "CT_DISPLAY_MEDIUM";
    public function getLabel()
    {
        return "Medium Display Block";
    }

    public function getCategory()
    {
        return CTCategory::DISPLAY;
    }

}