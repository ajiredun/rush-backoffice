<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class ThreeDisplayCT extends AbstractContentType
{

    const CODE = "CT_DISPLAY_THREE";
    public function getLabel()
    {
        return "Display Three Images with links";
    }

    public function getCategory()
    {
        return CTCategory::DISPLAY;
    }

}