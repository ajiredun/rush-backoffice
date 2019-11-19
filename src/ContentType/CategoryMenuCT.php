<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Entity\ObjectMenu;
use App\Enums\CTCategory;

class CategoryMenuCT extends AbstractContentType
{

    const CODE = "CT_MENU_CATEGORY";


    public function getLabel()
    {
        return "Category Menu";
    }

    public function getCategory()
    {
        return CTCategory::MENU;
    }

    public function getObjectRelation()
    {
        return [
            [
                'type' => ObjectMenu::class,
                'formName' => 'menu'
            ]
        ];
    }

}