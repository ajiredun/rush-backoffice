<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enums\UserStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


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
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'rushadmin'
        ));

        $manager->persist($user);

        $user2 = new User();
        $user2->setFirstname('user');
        $user2->setLastname('user');
        $user2->setEmail('user@rushframework.com');
        $user2->setStatus(UserStatus::ACTIVE);
        $user2->setPassword($this->passwordEncoder->encodePassword(
            $user2,
            'rushadmin'
        ));

        $manager->persist($user2);

        $manager->flush();
    }
}
