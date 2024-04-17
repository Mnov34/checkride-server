<?php

namespace App\models;

require './src/helpers/model.php';

use PDO;

class Bike {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createBike($model, $brand) {
        $sql = "INSERT INTO bikes (model, brand) VALUES (:model, :brand)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['name' => $model, 'email' => $brand]);
    }

    public function getAllBikes() {
        $stmt = $this->pdo->query('SELECT * FROM bikes');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBike($id) {
        $sql = "SELECT * FROM bikes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function updateBike($id, $model, $brand) {
        $sql = "UPDATE bikes SET model = :model, brand = :brand WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'model' => $model, 'brand' => $brand]);
    }

    public function deleteBike($id) {
        $sql = "DELETE FROM bikes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

}