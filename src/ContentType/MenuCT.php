<?php


namespace App\ContentType;


use App\ContentType\Base\AbstractContentType;
use App\Enums\CTCategory;

class MenuCT extends AbstractContentType
{

    const CODE = "CT_MENU_MAIN";


    public function getLabel()
    {
        return "Main Menu 01";
    }

    public function getCategory()
    {
        return CTCategory::MENU;
    }

}