<?php

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class RewriteMiddleware implements IMiddleware {

    public function handle(Request $request)  : void {

        $request->setRewriteCallback(function() {
            return 'ok';
        });

    }

}