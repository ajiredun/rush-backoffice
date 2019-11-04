<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class SmallDisplayCT extends AbstractContentType
{

    const CODE = "CT_DISPLAY_SMALL";
    public function getLabel()
    {
        return "Small Display Block";
    }

    public function getCategory()
    {
        return CTCategory::DISPLAY;
    }

}