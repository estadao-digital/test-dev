<?php

namespace app\lib;

use app\models\Users;

class Identity {

    public static function getToken() : string
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
    
        $token = str_replace('Bearer', '', $token);
        $token = trim($token);

        return $token;
    }

    public static function getIdentity()
    {
        $user = Users::findByToken(self::getToken());
        return $user;
    }

}