<?php

namespace app\lib\web;

class Session
{
    /**
     * open the session
     * @return void
     */
    public static function open(): void
    {
        if (!self::isActive()) {
            session_start();
        }
    }

    /**
     * check if session is active
     * @return bool session is active return true
     */
    public static function isActive(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * set flashdata in session
     * @param string key
     * @param mixed value
     * @return void
     */
    public static function setFlash(string $key, $value): void
    {
        self::open();
        $_SESSION[$key] = $value;
    }

    /**
     * get flash data information
     * @param string key
     * @param bool if true, remove the value after getting it
     * @return string|null
     */
    public static function getFlash(string $key, bool $remove = false): ?string
    {
        self::open();
        $value = $_SESSION[$key] ?? null;
        
        if ($remove){
            unset($_SESSION[$key]);
        }

        return $value;
    }
}