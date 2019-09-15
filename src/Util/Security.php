<?php


namespace App\Util;


use App\Entity\User;

class Security
{
    static function createActivationLink(User $user)
    {
        return "rfactlink.".md5("rf.". $user->getEmail());
    }
}