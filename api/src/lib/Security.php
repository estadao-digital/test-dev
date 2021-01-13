<?php

namespace app\lib;

class Security {

    /**
     * Generate a password hash
     * 
     * @param string $password
     * 
     * @return string hash
     */
    public static function generateHash(string $password) : string {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verifyPasswordHash(string $password, string $hash) : bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Generate a random and unique token
     * 
     * @return string tokens
     */
    public static function generateToken() : string {
        return hash('sha256', uniqid(rand()));
    }
}