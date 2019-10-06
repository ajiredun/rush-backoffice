<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class OneThirdImageTwoThirdTextCT extends AbstractContentType
{
    const CODE = "CT_ONE_THIRD_IMAGE_TWO_THIRD_TEXT";

    const IMAGE_ON_LEFT = "left";
    const IMAGE_ON_RIGHT = "right";

    public function getLabel()
    {
        return "1/3 Image 2/3 Text";
    }

    public function getCategory()
    {
        return CTCategory::BASIC;
    }
}