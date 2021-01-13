<?php

namespace app\lib\rest;


interface IdentityInterface {

    public static function findByToken(string $token);
}