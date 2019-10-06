<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class FullTextCT extends AbstractContentType
{
    const CODE = "CT_FULL_TEXT";

    public function getLabel()
    {
        return "Full Text";
    }

    public function getCategory()
    {
        return CTCategory::BASIC;
    }
}