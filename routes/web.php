<?php

use core\Ryder;

$routes = new Ryder();

$routes::get('/', 'HomeController', 'test');
$routes::post('/', 'HomeController', 'test');
$routes->run();