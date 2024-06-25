<?php

use core\Ryder;

$app = new Ryder();

/**
 * @throws Exception
 */
function view($view, $params = []) {
    global $routes;
    return $routes->render($view, $params);
}