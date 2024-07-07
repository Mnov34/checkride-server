<?php

use app\router\Router;

require_once 'src/app/router/Router.php';
require_once 'vendor/autoload.php';

$router = new Router();
$router->route($_SERVER['REQUEST_URI']);