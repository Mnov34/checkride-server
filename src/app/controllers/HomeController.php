<?php

namespace app\controllers;

class HomeController {
    private MotorcyclesController $motorcycleModel;

    final public function __construct() {
        $this->motorcycleModel = new MotorcyclesController();
    }

    final public function index(): void {
        $motorcycles = $this->motorcycleModel->listMotorcycles();
        require_once 'src/views/home/index.php';
    }

}