<?php

namespace App\DataFixtures;

use App\Entity\Layout;
use App\Entity\VisualPack;
use App\Enums\LayoutCode;
use App\Enums\SlotCode;
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

        //CREATE LAYOUT DEFAULT
        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');

        $layout->setCode(LayoutCode::LAYOUT_01);
        $layout->setTitle('Layout 01');
        $layout->setDescription('0.33 0.66');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-4" >
<div class="slot slot-4" data-slot="S_SLOT_02"></div>
</div>
<div class="col-md-8" >
<div class="slot slot-4" data-slot="S_SLOT_03"></div>
</div>
</div>
<div class="row">
<div class="col-md-12" >
<div class="slot slot-1"  data-slot="S_SLOT_04"></div>
</div>
</div>  
        ');

        $manager->persist($layout);
        $manager->flush();


        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');
        $layout->setCode(LayoutCode::LAYOUT_02);
        $layout->setTitle('Layout 02');
        $layout->setDescription('0.5 0.5');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-6" >
<div class="slot slot-4" data-slot="S_SLOT_02"></div>
</div>
<div class="col-md-6" >
<div class="slot slot-4" data-slot="S_SLOT_03"></div>
</div>
</div>
<div class="row">
<div class="col-md-12" >
<div class="slot slot-1"  data-slot="S_SLOT_04"></div>
</div>
</div>  
        ');

        $manager->persist($layout);
        $manager->flush();

        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');
        $layout->setCode(LayoutCode::LAYOUT_03);
        $layout->setTitle('Layout 03');
        $layout->setDescription('0.33 0.33 0.33');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04,
            SlotCode::SLOT_05,
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-4" ><div class="slot slot-4" data-slot="S_SLOT_02"></div></div>
<div class="col-md-4" ><div class="slot slot-4" data-slot="S_SLOT_03"></div></div>
<div class="col-md-4" ><div class="slot slot-4" data-slot="S_SLOT_04"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-1"  data-slot="S_SLOT_05"></div></div>
</div>  
        ');

        $manager->persist($layout);
        $manager->flush();

        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');
        $layout->setCode(LayoutCode::LAYOUT_04);
        $layout->setTitle('Layout 04');
        $layout->setDescription('0.5 0.25 0.25');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04,
            SlotCode::SLOT_05,
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-6" ><div class="slot slot-4" data-slot="S_SLOT_02"></div></div>
<div class="col-md-3" ><div class="slot slot-4" data-slot="S_SLOT_03"></div></div>
<div class="col-md-3" ><div class="slot slot-4" data-slot="S_SLOT_04"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-1"  data-slot="S_SLOT_05"></div></div>
</div>  
        ');

        $manager->persist($layout);
        $manager->flush();

        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');
        $layout->setCode(LayoutCode::LAYOUT_05);
        $layout->setTitle('Layout 05');
        $layout->setDescription('0.25 0.25 0.5');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04,
            SlotCode::SLOT_05,
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-3" ><div class="slot slot-4" data-slot="S_SLOT_02"></div></div>
<div class="col-md-3" ><div class="slot slot-4" data-slot="S_SLOT_03"></div></div>
<div class="col-md-6" ><div class="slot slot-4" data-slot="S_SLOT_04"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-1"  data-slot="S_SLOT_05"></div></div>
</div>  
        ');

        $manager->persist($layout);
        $manager->flush();


        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');
        $layout->setCode(LayoutCode::LAYOUT_06);
        $layout->setTitle('Layout 06');
        $layout->setDescription('0.25 0.5 0.25');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04,
            SlotCode::SLOT_05,
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-3" ><div class="slot slot-4" data-slot="S_SLOT_02"></div></div>
<div class="col-md-6" ><div class="slot slot-4" data-slot="S_SLOT_03"></div></div>
<div class="col-md-3" ><div class="slot slot-4" data-slot="S_SLOT_04"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-1"  data-slot="S_SLOT_05"></div></div>
</div>  
        ');

        $manager->persist($layout);
        $manager->flush();

        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');
        $layout->setCode(LayoutCode::LAYOUT_07);
        $layout->setTitle('Layout 07');
        $layout->setDescription('0.5 0.5 / 0.5 0.5');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04,
            SlotCode::SLOT_05,
            SlotCode::SLOT_06,
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-6" ><div class="slot slot-2" data-slot="S_SLOT_02"></div></div>
<div class="col-md-6" ><div class="slot slot-2" data-slot="S_SLOT_03"></div></div>
</div>
<div class="row">
<div class="col-md-6" ><div class="slot slot-2" data-slot="S_SLOT_04"></div></div>
<div class="col-md-6" ><div class="slot slot-2" data-slot="S_SLOT_05"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-1"  data-slot="S_SLOT_06"></div></div>
</div>  
        ');

        $manager->persist($layout);
        $manager->flush();

        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');
        $layout->setCode(LayoutCode::LAYOUT_08);
        $layout->setTitle('Layout 08');
        $layout->setDescription('0.33 0.66 / 0.66 0.33');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04,
            SlotCode::SLOT_05,
            SlotCode::SLOT_06,
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-4" ><div class="slot slot-2" data-slot="S_SLOT_02"></div></div>
<div class="col-md-8" ><div class="slot slot-2" data-slot="S_SLOT_03"></div></div>
</div>
<div class="row">
<div class="col-md-8" ><div class="slot slot-2" data-slot="S_SLOT_04"></div></div>
<div class="col-md-4" ><div class="slot slot-2" data-slot="S_SLOT_05"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-1"  data-slot="S_SLOT_06"></div></div>
</div>  
        ');

        $manager->persist($layout);
        $manager->flush();


        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');
        $layout->setCode(LayoutCode::LAYOUT_09);
        $layout->setTitle('Layout 09');
        $layout->setDescription('0.66 0.33 / 0.33 0.66');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04,
            SlotCode::SLOT_05,
            SlotCode::SLOT_06,
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-8" ><div class="slot slot-2" data-slot="S_SLOT_02"></div></div>
<div class="col-md-4" ><div class="slot slot-2" data-slot="S_SLOT_03"></div></div>
</div>
<div class="row">
<div class="col-md-4" ><div class="slot slot-2" data-slot="S_SLOT_04"></div></div>
<div class="col-md-8" ><div class="slot slot-2" data-slot="S_SLOT_05"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-1"  data-slot="S_SLOT_06"></div></div>
</div>  
        ');

        $manager->persist($layout);
        $manager->flush();


        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');
        $layout->setCode(LayoutCode::LAYOUT_10);
        $layout->setTitle('Layout 10');
        $layout->setDescription('0.66 0.33 / 1.0');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04,
            SlotCode::SLOT_05,
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-8" ><div class="slot " data-slot="S_SLOT_02"></div></div>
<div class="col-md-4" ><div class="slot " data-slot="S_SLOT_03"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-3" data-slot="S_SLOT_04"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-1"  data-slot="S_SLOT_05"></div></div>
</div>   
        ');

        $manager->persist($layout);
        $manager->flush();


        $layout = new Layout();
        $layout->setVisual('assets/admin/img/sketch.jpg');
        $layout->setCode(LayoutCode::LAYOUT_10);
        $layout->setTitle('Layout 10');
        $layout->setDescription('0.33 0.66 / 1.0');
        $layout->setVisualPack($defaultVisualPack);
        $layout->setSlots([
            SlotCode::SLOT_01,
            SlotCode::SLOT_02,
            SlotCode::SLOT_03,
            SlotCode::SLOT_04,
            SlotCode::SLOT_05,
        ]);
        $layout->setStructure('
<div class="row">
<div class="col-md-12" >
<div class="slot" data-slot="S_SLOT_01"></div>
</div>
</div>
<div class="row">
<div class="col-md-4" ><div class="slot " data-slot="S_SLOT_02"></div></div>
<div class="col-md-8" ><div class="slot " data-slot="S_SLOT_03"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-3" data-slot="S_SLOT_04"></div></div>
</div>
<div class="row">
<div class="col-md-12" ><div class="slot slot-1"  data-slot="S_SLOT_05"></div></div>
</div>   
        ');

        $manager->persist($layout);
        $manager->flush();

    }
}
