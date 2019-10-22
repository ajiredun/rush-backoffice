<?php


namespace App\Event;


use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreateEvent extends Event
{
    public const NAME = 'rf.event.user.create';

    protected $user;

    protected $frontOffice;

    public function __construct(User $user, $frontOffice = false)
    {
        $this->user = $user;
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