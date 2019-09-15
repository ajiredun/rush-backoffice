<?php


namespace App\Event;


use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreateEvent extends Event
{
    public const NAME = 'rf.event.user.create';

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}