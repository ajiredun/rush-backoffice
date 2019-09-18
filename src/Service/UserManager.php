<?php


namespace App\Service;


use App\Entity\User;
use App\Enums\UserStatus;
use App\Event\UserCreateEvent;
use App\Event\UserPasswordEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class UserManager
{

    private $em;
    private $passwordEncoder;
    private $eventDispatcher;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param array $data
     * @param array $roles
     * @param string $status
     * @return User
     */
    public function createUser(array $data, $roles = [], $status = UserStatus::INACTIVE)
    {
        $user = new User();
        $user->setStatus($status);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setEmail($data['email']);
        $user->setRoles($roles);
        $this->setPassword($user, $data['password'], false);

        return $this->createUserBase($user, $roles, $status);
    }

    public function createUserFromObject(User $user, $roles = [], $status = UserStatus::INACTIVE)
    {
        $this->setPassword($user, $user->getPassword(), false);

        return $this->createUserBase($user, $roles, $status);
    }

    protected function createUserBase(User $user, $roles = [], $status = UserStatus::INACTIVE)
    {
        $user->setStatus($status);
        $user->setRoles($roles);
        $event = new UserCreateEvent($user);
        $this->eventDispatcher->dispatch($event, UserCreateEvent::NAME);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function setPassword(User $user, $password = null, $propagation = true)
    {
        if (empty($password)) {
            $password = rand(1000000000,1000000000000);
        }

        if ($propagation) {
            $event = new UserPasswordEvent($user, $password);
            $this->eventDispatcher->dispatch($event, UserPasswordEvent::NAME);
        }

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));
    }

    /**
     * @param $email
     * @return bool
     */
    public function isUserExist($email)
    {
        $ur = $this->em->getRepository(User::class);
        $user = $ur->findOneBy(array('email'=>$email));

        if ($user) {
            return true;
        }

        return false;
    }
}