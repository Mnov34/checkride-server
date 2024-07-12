<?php

namespace app\controllers;

use app\models\Maintenance;
use Exception;
use RuntimeException;

class MaintenanceController {
    private Maintenance $maintenanceModel;

    final public function __construct() {
        $this->maintenanceModel = new Maintenance();
    }

    final public function index(): void {
        $motorcycles = $this->maintenanceModel->getAllMaintenance();
        require_once 'src/views/home/index.php';
    }

    final public function add(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $brand = $_POST['formBrand'] ?? null;
            $part = $_POST['formPart'] ?? null;
            $model = $_POST['formModel'] ?? null;
            $cylinder = $_POST['formCylinder'] ?? null;
            $year = $_POST['formYear'] ?? null;
            $plate = $_POST['formPlate'] ?? null;
            try {
                $this->validateFields([$brand, $part, $model, $cylinder, $year, $plate]);

                $this->maintenanceModel->setBrand($brand);
                $this->maintenanceModel->setPart($part);
                $this->maintenanceModel->setModel($model);
                $this->maintenanceModel->setCylinder($cylinder);
                $this->maintenanceModel->setProdYear($year);
                $this->maintenanceModel->setPlate($plate);

                $maintenanceId = $this->maintenanceModel->createMaintenance($this->maintenanceModel);
                //include 'src/views/home/maintenanceSuccess.php';

                header('Location: /');
            } catch (Exception $e) {
                $error = $e->getMessage();
                include 'src/views/shared/operationFailed.php';
                header('Location: /');
            }
        }
    }


    final public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $motorcycleId = isset($_POST['motorcycle_id']) ? (int)$_POST['motorcycle_id'] : null;
            $brand = $_POST['formBrand'] ?? null;
            $part = $_POST['formPart'] ?? null;
            $model = $_POST['formModel'] ?? null;
            $cylinder = $_POST['formCylinder'] ?? null;
            $year = $_POST['formYear'] ?? null;
            $plate = $_POST['formPlate'] ?? null;
            $kilometers = $_POST['formKilometer'] ?? null;

            try {
                $this->validateFields([$motorcycleId, $brand, $part, $model, $cylinder, $year, $plate, $kilometers]);

                $this->maintenanceModel->setMotorcycleId($motorcycleId);
                $this->maintenanceModel->setBrand($brand);
                $this->maintenanceModel->setPart($part);
                $this->maintenanceModel->setModel($model);
                $this->maintenanceModel->setCylinder($cylinder);
                $this->maintenanceModel->setProdYear($year);
                $this->maintenanceModel->setPlate($plate);

                $this->maintenanceModel->updateMaintenance($this->maintenanceModel);

                header('Location: /');
            } catch (Exception $e) {
                $error = $e->getMessage();
                include 'src/views/shared/operationFailed.php';
                header('Location: /');
            }
        }
    }


    private function validateFields(array $list): void {
        foreach ($list as $value) {
            if (empty($value)) {
                throw new RuntimeException('All fields are required.');
            }
        }
    }

}