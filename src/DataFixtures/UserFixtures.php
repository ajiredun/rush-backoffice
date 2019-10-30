<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enums\Roles;
use App\Enums\UserStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
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
        $user->setFirstname('Ajir');
        $user->setLastname('Edun');
        $user->setEmail('ajir.edun@gmail.com');
        $user->setMobile('59033978');
        $user->setStatus(UserStatus::ACTIVE);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'rushadmin'
        ));

        $manager->persist($user);

        $manager->flush();
    }
}
