<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Entity\ObjectCategory;
use App\Enums\CTCategory;

class CategoryInfoCT extends AbstractContentType
{

    const CODE = "CT_CATEGORY_INFO";


    public function getLabel()
    {
        return "Category Info";
    }

    public function getCategory()
    {
        return CTCategory::CATEGORY;
    }

    public function getObjectRelation()
    {
        return [
            [
                'type' => ObjectCategory::class,
                'formName' => 'category'
            ]
        ];
    }
}