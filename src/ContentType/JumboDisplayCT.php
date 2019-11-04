<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class JumboDisplayCT extends AbstractContentType
{

    const CODE = "CT_DISPLAY_JUMBO";
    public function getLabel()
    {
        return "Jumbo Display Block";
    }

    public function getCategory()
    {
        return CTCategory::DISPLAY;
    }

}