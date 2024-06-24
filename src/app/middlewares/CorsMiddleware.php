<?php

namespace src\app\middlewares;

use core\Request;

class CorsMiddleware {
    public function handle(Request $request) {
        parent::handle($request);
    }
}