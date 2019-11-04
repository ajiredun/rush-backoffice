<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Entity\ObjectMenu;
use App\Enums\CTCategory;

class SpacerCT extends AbstractContentType
{

    const CODE = "CT_SPACER";


    public function getLabel()
    {
        return "SPACER";
    }

    public function getCategory()
    {
        return CTCategory::BASIC;
    }

}