<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class HalfImageHalfTextCT extends AbstractContentType
{

    const CODE = "CT_HALF_IMAGE_HALF_TEXT";

    const IMAGE_ON_LEFT = "left";
    const IMAGE_ON_RIGHT = "right";


    public function getLabel()
    {
        return "1/2 Image 1/2 Text";
    }

    public function getCategory()
    {
        return CTCategory::BASIC;
    }

}