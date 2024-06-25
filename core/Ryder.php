<?php

namespace core;

use RuntimeException;

class Ryder {
    use Router, UrlEngine, View;

    private Request $request;

    public function __construct() {
        $this->request = new Request();
    }

    /**
     * @throws RuntimeException
     */
    public function run() {
        $method = $this->method();
        $path = $this->normalizePath($this->path());
        $callable = $this->match($method, $path);

        if (!$callable) {
            throw new RuntimeException('404 NOT FOUND', 404);
        }

        $class = "src\\app\\controllers\\" . $callable['class'];
        if (!class_exists($class)) {
            throw new RuntimeException('Class does not exist', 500);
        }

        $method = $callable['method'];

        if (!is_callable($class, $method)) {
            throw new RuntimeException("$method is not a valid method in class $callable[class]", 500);
        }

        $class = new $class();

        $class->$method($this->request);
    }

    private function match($method, $url) {
        foreach (self::$map[$method] as $uri => $call) {
            if ($uri !== '/' && str_ends_with($url, '/')) {
                $url = substr($url, 0, -1);
            }
            if ($url === $uri) {
                return $call;
            }
        }
        return false;
    }

    private function normalizePath($path) {
        // Remove the base directory from the path
        $baseDir = '/checkride-server/public';
        if (str_starts_with($path, $baseDir)) {
            $path = substr($path, strlen($baseDir));
        }
        // Ensure the path starts with a slash
        if ($path === '') {
            $path = '/';
        }
        return $path;
    }
}