<?php

namespace core;

trait UrlEngine {

    public function method(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function path() {
        return strtok($_SERVER["REQUEST_URI"], '?');
    }
}