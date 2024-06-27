<?php

namespace src\app\controllers;

use src\app\models\Database;
use src\app\models\Motorcycle;

class MotorcyclesController {
    private Motorcycle $motorcycleModel;

    public function __construct() {
        $database = new Database();
        $this->motorcycleModel = new Motorcycle($database);
    }

    final public function create(string $brand, string $model, string $cylinder, string $prod_year, int $plate): void {
        $this->motorcycleModel->createMotorcycle($brand, $model, $cylinder, $prod_year, $plate);
        include '../views/createBike.php';
    }

    final public function listMotorcycles(): array {
        return $this->motorcycleModel->getAllMotorcycles();
    }

    final public function update(int $id, string $brand, string $model, string $cylinder, string $prod_year, int $plate): void {
        $bike = $this->motorcycleModel->getMotorcycle($id);
        $this->motorcycleModel->updateMotorcycle($bike, $model, $brand, $cylinder, $prod_year, $plate);
        include '../views/updateBike.php';
    }

    final public function delete(int $id): void {
        $this->motorcycleModel->deleteMotocycle($id);
        include '../views/deleteBike.php';
    }

}