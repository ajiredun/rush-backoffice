<?php


namespace App\Event;


use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserPasswordEvent extends Event
{
    public const NAME = 'rf.event.user.password';

    protected $user;

    protected $password;

    protected $frontOffice;

    public function __construct(User $user, $password, $frontOffice = false)
    {
        $this->user = $user;
        $this->password = $password;
        $this->frontOffice = $frontOffice;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isFrontOffice(): bool
    {
        return $this->frontOffice;
    }

    /**
     * @param bool $frontOffice
     */
    public function setFrontOffice(bool $frontOffice): void
    {
        $this->frontOffice = $frontOffice;
    }
}