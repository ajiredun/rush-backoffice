<?php


namespace App\Service;


use App\Entity\ApiToken;
use App\Entity\User;
use App\Enums\UserStatus;
use App\Event\UserCreateEvent;
use App\Event\UserPasswordEvent;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
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

    public function verifyPassword(User $user, $password)
    {
        return $this->passwordEncoder->isPasswordValid($user, $password);
    }

    public function generateToken(User $user)
    {
        $userTokens = $user->getApiTokens();
        $token = null;
        foreach ($userTokens as $apiToken)
        {
            if (!$apiToken->isExpired()) {
                return $apiToken;
            }
        }

        if (is_null($token)) {
            //all tokens have been expired or no tokens at all
            $token = new ApiToken($user);
            $user->addApiToken($token);

            $this->em->persist($token);
            $this->em->flush();

            return $token;
        }

        return $token;
    }

    public function getActiveApiToken(User $user)
    {
        $userTokens = $user->getApiTokens();
        $token = null;
        foreach ($userTokens as $apiToken)
        {
            if (!$apiToken->isExpired()) {
                return $apiToken;
            }
        }

        return null;
    }

    /**
     * @param $email
     * @return bool
     */
    public function isUserExist($email)
    {
        $user = $this->getUserByEmail($email);

        if ($user) {
            return true;
        }

        return false;
    }

    /**
     * @param $email
     * @return User|null
     */
    public function getUserByEmail($email)
    {
        $ur = $this->em->getRepository(User::class);
        $user = $ur->findOneBy(array('email'=>$email));

        return $user;
    }
}