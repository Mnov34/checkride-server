<?php

namespace src\app\controllers;

use src\app\models\Bike;

require_once '../../models/Bike.php';

class BikeController {
    protected $pdo;
    protected Bike $bikeModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->bikeModel = new Bike($this->pdo);
    }

    public function create($model, $brand) {
        $this->bikeModel->create($model, $brand);
        include '../views/createBike.php';
    }

    public function list() {
        $bikes = $this->bikeModel->getAllBikes();
        include '../views/viewBikes.php';
    }

    public function update($id, $model, $brand) {
        $bike = $this->bikeModel->getBike($id);
        $this->bikeModel->updateBike($bike, $model, $brand);
        include '../views/updateBike.php';
    }

    public function delete($id) {
        $this->bikeModel->deleteBike($id);
        include '../views/deleteBike.php';
    }

}