<?php

namespace app\controllers;

class ContactController {

    final public function index(): void {
        require_once 'src/views/contact/index.php';
    }

}