<?php

namespace app\controllers;

use app\models\Motorcycle;
use Exception;
use RuntimeException;

class MotorcyclesController {
    private Motorcycle $motorcycleModel;

    public function __construct() {
        $this->motorcycleModel = new Motorcycle();
    }

    final public function index(): void {
        include 'src/views/motorcycles/index.php';
    }

    final public function create(string $brand, string $model, string $cylinder, string $prod_year, int $plate): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $brand = $_POST['motorcycle_brand'] ?? null;
            $model = $_POST['model'] ?? null;
            $cylinder = $_POST['cylinder'] ?? null;
            $prod_year = $_POST['prod_year'] ?? null;
            $plate = $_POST['plate'] ?? null;

            try {
                $this->validateFields([$brand, $model, $cylinder, $prod_year, $plate]);
                $motorcycle = new Motorcycle();
                $this->motorcycleModel->createMotorcycle($motorcycle);
                echo json_encode(['status' => 'success',
                                     'message' => 'Motorcycle added successfully.'], JSON_THROW_ON_ERROR);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_THROW_ON_ERROR);
            }
        }
        $this->motorcycleModel->createMotorcycle($brand, $model, $cylinder, $prod_year, $plate);
    }

    final public function getMotorcycle(int $id): bool {
        return $this->motorcycleModel->getMotorcycle($id);
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

    private function validateFields(array $list): void {
        foreach ($list as $value) {
            if (empty($value)) {
                throw new RuntimeException('All fields are required.');
            }
        }
    }

}