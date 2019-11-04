<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class TwoThirdImageOneThirdTextCT extends AbstractContentType
{
    const CODE = "CT_TWO_THIRD_IMAGE_ONE_THIRD_TEXT";

    const IMAGE_ON_LEFT = "left";
    const IMAGE_ON_RIGHT = "right";

    public function getLabel()
    {
        return "2/3 Image 1/3 Text";
    }

    public function getCategory()
    {
        return CTCategory::BASIC;
    }
}