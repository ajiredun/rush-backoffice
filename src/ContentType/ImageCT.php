<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class ImageCT extends AbstractContentType
{

    const CODE = "CT_IMAGE";
    public function getLabel()
    {
        return "Image Block";
    }

    public function getCategory()
    {
        return CTCategory::DISPLAY;
    }

}