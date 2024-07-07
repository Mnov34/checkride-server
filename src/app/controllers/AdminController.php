<?php

namespace app\controllers;

class AdminController {

    final public function index(): void {
        require_once 'src/views/admin/index.php';
    }

    final public function addUser(): void {
        require_once 'src/views/admin/addUser.php';
    }

}