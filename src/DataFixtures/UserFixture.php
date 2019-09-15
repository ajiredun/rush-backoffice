<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enums\UserStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setFirstname('Admin');
        $user->setLastname('Admin');
        $user->setEmail('admin@rushframework.com');
        $user->setStatus(UserStatus::ACTIVE);
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $user2 = new User();
        $user2->setFirstname('user');
        $user2->setLastname('user');
        $user2->setEmail('user@rushframework.com');
        $user2->setStatus(UserStatus::ACTIVE);

        $manager->persist($user2);

        $manager->flush();
    }
}
