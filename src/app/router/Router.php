<?php

namespace app\router;

use app\controllers\HomeController;
use app\controllers\MotorcyclesController;
use app\controllers\ContactController;
use app\controllers\AdminController;

class Router {

    final public function route(string $requestUri): void {
        if (preg_match('/^\/public\/([^\s?]*)/', $requestUri, $matches)) {
            header("Location: /{$matches[1]}", true, 302);
            exit();
        }

        switch ($requestUri) {
            case '/':
            case '/index.php':
                require_once 'src/app/controllers/HomeController.php';
                $controller = new HomeController();
                $controller->index();
                break;

            case '/bikes/':
                require_once 'src/app/controllers/MotorcyclesController.php';
                $controller = new MotorcyclesController();
                $controller->index();
                break;

            case '/contact/':
                require_once 'src/app/controllers/ContactController.php';
                $controller = new ContactController();
                $controller->index();
                break;

            case '/admin/add-user/':
                require_once 'src/app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->addUser();
                break;

            case '/admin/':
                require_once 'src/app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->index();
                break;

            default:
                http_response_code(404);
                require_once 'src/views/shared/404.php';
                break;
        }
    }

}