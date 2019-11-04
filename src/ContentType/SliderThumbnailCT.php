<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class SliderThumbnailCT extends AbstractContentType
{
    const CODE = "CT_SLIDER_THUMBNAIL";

    public function getLabel()
    {
        return "Image Slider";
    }

    public function getCategory()
    {
        return CTCategory::SLIDER;
    }

}