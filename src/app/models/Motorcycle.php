<?php

namespace app\models;

use PDOException;

class Motorcycle {
    private Database $db;
    private int|null $id;
    private string $brand;
    private string $model;
    private string $cylinder;
    private mixed $prod_year;
    private int $plate;
    private mixed $acquisition_date;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * get the current object id
     * @return int
     */
    final public function getId(): int {
        return $this->id;
    }

    /**
     * @return mixed
     */
    final public function getBrand(): string {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    final public function setBrand(string $brand): void {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    final public function getModel(): string {
        return $this->model;
    }

    /**
     * @param mixed $model
     * @return void
     */
    final public function setModel(string $model): void {
        $this->model = $model;
    }

    /**
     * @return string
     */
    final public function getCylinder(): string {
        return $this->cylinder;
    }

    /**
     * @param mixed $cylinder
     * @return void
     */
    final public function setCylinder(string $cylinder): void {
        $this->cylinder = $cylinder;
    }

    /**
     * @return mixed
     */
    final public function getProdYear(): string {
        return $this->prod_year;
    }

    /**
     * @param mixed $prod_year
     */
    final public function setProdYear(string $prod_year): void {
        $this->prod_year = $prod_year;
    }

    /**
     * @return mixed
     */
    final public function getPlate(): string {
        return $this->plate;
    }

    /**
     * @param mixed $plate
     */
    final public function setPlate(string $plate): void {
        $this->plate = $plate;
    }

    /**
     * @return mixed
     */
    final public function getAcquisitionDate(): string {
        return $this->acquisition_date;
    }

    /**
     * @param mixed $acquisition_date
     */
    final public function setAcquisitionDate(string $acquisition_date): void {
        $this->acquisition_date = $acquisition_date;
    }

    final public function createMotorcycle(Motorcycle $motorcycle): bool {
        try {
            $this->db->query("INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, Id_checkride_user) VALUES (?, ?, ?, ?, ?, 1)");

            $this->setBrand($motorcycle->getBrand());
            $this->setModel($motorcycle->getModel());
            $this->setCylinder($motorcycle->getCylinder());
            $this->setProdYear($motorcycle->getProdYear());
            $this->setPlate($motorcycle->getPlate());

            return $this->db->execute([$this->getBrand(), $this->getModel(), $this->getCylinder(), $this->getProdYear(),
                                          $this->getPlate()]);
        } catch (PDOException $e) {
            throw new PDOException("Error creating new motorcycle: " . $e->getMessage());
        }
    }

    final public function getMotorcycle(int $id): bool {
        try {
            $this->db->query("SELECT * FROM motorcycle WHERE Id_motorcycle=?");
            return $this->db->single([$id]);
        } catch (PDOException $e) {
            throw new PDOException("Error finding motorcycle: " . $e->getMessage());
        }
    }

    final public function getAllMotorcycles(): array {
        try {
            $this->db->query("
            SELECT 
                m.Id_motorcycle, m.brand, m.model, m.plate, 
                mt.maintenance_kilometer, mt.parts, mt.maintenance_date
            FROM motorcycle m
            INNER JOIN maintenance mt ON m.Id_motorcycle = mt.Id_motorcycle
        ");
            return $this->db->resultSet();
        } catch (PDOException $e) {
            throw new PDOException("Error finding motorcycles: " . $e->getMessage());
        }
    }

    final public function updateMotorcycle(int $id, string $brand, string $model, string $cylinder, string $prod_year, int $plate): bool {
        try {
            $this->db->query("UPDATE motorcycle SET brand=?, model=?, cylinder=?, prod_year=?, plate=? WHERE Id_motorcycle=?");
            return $this->db->execute([$brand, $model, $cylinder, $prod_year, $plate, $id]);
        } catch (PDOException $e) {
            throw new PDOException("Error updating motorcycle: " . $e->getMessage());
        }
    }

    final public function deleteMotocycle(int $id): bool {
        try {
            $this->db->query("DELETE FROM motorcycle WHERE Id_motorcycle=?");
            return $this->db->execute([$id]);
        } catch (PDOException $e) {
            throw new PDOException("Error deleting motorcycle: " . $e->getMessage());
        }
    }

}