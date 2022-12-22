<?php
namespace App\Src\Core\Utils;

class SessionUtils
{    
    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($id, $data)
    {
        self::StartSession();
        $_SESSION[$id] = $data;
    }

    public static function get($id)
    {
        self::StartSession();
        return $_SESSION[$id];
    }

    public static function isSet($id)
    {
        self::StartSession();
        return isset($_SESSION[$id]);
    }

    public static function unset($id)
    {
        self::StartSession();
        unset($_SESSION[$id]);
    }
}