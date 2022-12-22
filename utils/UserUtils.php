<?php
namespace App\Src\Core\Utils;

use App\Src\Entity\User;

class UserUtils
{
    public static function isLogedIn(): bool
    {
        return SessionUtils::isSet(User::SESSION_NAME);
    }

    public static function isLogedInAdmin(): bool
    {
        return SessionUtils::isSet(User::SESSION_NAME) && SessionUtils::get(User::SESSION_NAME)->IsAdmin();
    }

    public static function getLogedIn()
    {
        return SessionUtils::get(User::SESSION_NAME) ?? null;
    }

    public static function logoutUser()
    {
        SessionUtils::unset(User::SESSION_NAME);
    }
}