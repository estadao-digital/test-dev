<?php

namespace app\lib\rest;

use app\lib\Identity;
use app\lib\Response;

class Controller {

    public function isAuthenticated() {
        $user = Identity::getIdentity();
        if (!$user) {
            Response::sendResponse(Response::UNAUTHORIZED, Response::UNAUTHORIZED);
        }
    }
}