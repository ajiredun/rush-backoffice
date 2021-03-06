<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Entity\ObjectMenu;
use App\Enums\CTCategory;

class SideMenuCT extends AbstractContentType
{

    const CODE = "CT_MENU_SIDE";


    public function getLabel()
    {
        return "Side Menu";
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