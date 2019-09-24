<?php

namespace App\DataFixtures;

use App\Entity\Layout;
use App\Entity\Page;
use App\Entity\User;
use App\Entity\VisualPack;
use App\Enums\LayoutCode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $userRepository = $manager->getRepository(User::class);
        $layoutRepository = $manager->getRepository(Layout::class);
        $vpRepository = $manager->getRepository(VisualPack::class);

        $vp = $vpRepository->findOneBy(['active'=>true]);
        $user = $userRepository->findOneBy(['email'=>'admin@rushframework.com']);
        $layout = $layoutRepository->findOneBy(['code'=>LayoutCode::LAYOUT_01, 'visualPack'=>$vp]);

        //Create homepage
        $home = new Page();
        $home->setRoute("/");
        $home->setLayout($layout);
        $home->setLastModifiedBy($user);
        $home->setName("Homepage");
        $home->setPublished(true);

        $manager->persist($home);
        $manager->flush($home);

        $layout = $layoutRepository->findOneBy(['code'=>LayoutCode::LAYOUT_03, 'visualPack'=>$vp]);
        //Create about us
        $aboutUs = new Page();
        $aboutUs->setRoute("/about-us");
        $aboutUs->setLayout($layout);
        $aboutUs->setLastModifiedBy($user);
        $aboutUs->setName("About Us");
        $aboutUs->setPublished(true);

        $manager->persist($aboutUs);
        $manager->flush($aboutUs);

        $layout = $layoutRepository->findOneBy(['code'=>LayoutCode::LAYOUT_02, 'visualPack'=>$vp]);
        //Create login
        $login = new Page();
        $login->setRoute("/login");
        $login->setLayout($layout);
        $login->setLastModifiedBy($user);
        $login->setName("Login");
        $login->setPublished(true);

        $manager->persist($login);
        $manager->flush($login);
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            VisualPackFixtures::class,
        );
    }
}
