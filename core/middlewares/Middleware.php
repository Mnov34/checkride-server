<?php

namespace core\middlewares;

use core\Request;

interface Middleware {
    public function setNext(Middleware $handler): Middleware;

    public function handle(Request $request);
}