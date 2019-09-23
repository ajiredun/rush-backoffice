<?php

namespace App\DataFixtures;

use App\Entity\Layout;
use App\Entity\VisualPack;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VisualPackFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //FIXTURES FOR THE DEFAULT Visual Pack
        $defaultVisualPack = new VisualPack();
        $defaultVisualPack->setActive(true);
        $defaultVisualPack->setCode("VP_DEFAULT");
        $defaultVisualPack->setTitle("Default");

        $manager->persist($defaultVisualPack);
        $manager->flush();

        //CREATE LAYOUT HOME FOR DEFAULT VISUAL PACK
        $layoutHome = new Layout();
        $layoutHome->setCode("L_HOME");
        $layoutHome->setTitle('Home');
        $layoutHome->setDescription('The home layout for the Default Visual Pack');
        $layoutHome->setVisualPack($defaultVisualPack);
        $layoutHome->setSlots(['S_NAV','S_HEADER','S_SIDE','S_MAIN','S_FOOTER']);


    }
}
