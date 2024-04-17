<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

require_once 'src/helpers/model.php';
require_once 'src/helpers/functions.php';

if (isset($_GET['controller']) && '' != $_GET['controller']) {
    $controller = $_GET['controller'];
} else {
    $controller = 'home';
}

if (isset($_GET['action']) && '' != $_GET['action']) {
    $action = $_GET['action'];
} else {
    $action = 'index';
}

$file = 'src/controllers/' . $controller . '/' . $action . '.php';
if (file_exists($file)) {
    require $file;
} else {
    show404();
}