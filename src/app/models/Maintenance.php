<?php

namespace app\models;

use PDOException;

class Maintenance {
    private Database $db;
    private int|null $id;
    private int $maintenance_kilometer;
    private string $part;
    private string $bills;
    private string $maintenance_date;

    private int|null $motorcycle_id;

    private string $brand;
    private string $model;
    private string $cylinder;
    private mixed $prod_year;
    private mixed $acquisition_date;
    private mixed $plate;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * @return mixed
     */
    final public function getId(): int {
        return $this->id;
    }

    final public function getPart(): string {
        return $this->part;
    }

    final public function setPart(string $part): void {
        $this->part = $part;
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
     */
    final public function setModel(string $model): void {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    final public function getCylinder(): string {
        return $this->cylinder;
    }

    /**
     * @param mixed $cylinder
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
    final public function getPlate(): mixed {
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

    final public function setMaintenanceKilometer(int $maintenance_kilometer): void {
        $this->maintenance_kilometer = $maintenance_kilometer;
    }

    final public function getMaintenanceKilometer(): int {
        return $this->maintenance_kilometer;
    }

    final public function getBills(): string {
        return $this->bills;
    }

    final public function setBills(string $bills): void {
        $this->bills = $bills;
    }

    final public function getMaintenanceDate(): string {
        return $this->maintenance_date;
    }

    final public function setMaintenanceDate(string $maintenance_date): void {
        $this->maintenance_date = $maintenance_date;
    }

    final public function setMotorcycleId(?int $motorcycle_id): void {
        $this->motorcycle_id = $motorcycle_id;
    }

    final public function getMotorcycleId(): ?int {
        return $this->motorcycle_id;
    }

    final public function createMaintenance(Maintenance $maintenance): false|string {
        try {
            $this->db->beginTransaction();

            $this->setBrand($maintenance->getBrand());
            $this->setModel($maintenance->getModel());
            $this->setCylinder($maintenance->getCylinder());
            $this->setProdYear($maintenance->getProdYear());
            $this->setPlate($maintenance->getPlate());

            $this->setPart($maintenance->getPart());

            $this->db->query("INSERT INTO motorcycle (brand, model, cylinder, prod_year, plate, Id_checkride_user) VALUES (?, ?, ?, ?, ?, 1)");

            $this->db->execute([$this->getBrand(), $this->getModel(), $this->getCylinder(), $this->getProdYear(),
                                   $this->getPlate()]);

            $motorcycleId = $this->db->getLastInserted();

            if ($this->getPart()) {
                $this->db->query("INSERT into maintenance (parts, Id_motorcycle) VALUES (?, ?)");
                $this->db->execute([$this->getPart(), $motorcycleId]);
            }

            $this->db->commit();

            return $this->db->getLastInserted();

        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new PDOException("Error creating new maintenance: " . $e->getMessage());
        }
    }

    final public function getAllMaintenance(): array {
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
            throw new PDOException("Error finding maintenances: " . $e->getMessage());
        }
    }

    final public function updateMaintenance(Maintenance $maintenance): false|string {
        try {
            $this->db->query("UPDATE maintenance SET Id_motorcycle = ?, maintenance_kilometer = ?, parts = ?, maintenance_date = ? WHERE Id_maintenance = ?");

            $this->setMotorcycleId($maintenance->getMotorcycleId());
            $this->setMaintenanceKilometer($maintenance->getMaintenanceKilometer());
            $this->setPart($maintenance->getPart());
            $this->setMaintenanceDate($maintenance->getMaintenanceDate());

            $this->db->execute([$this->getBrand(), $this->getModel(), $this->getCylinder(), $this->getProdYear(),
                                   $this->getPlate()]);

            return $this->db->getLastInserted();

        } catch (PDOException $e) {
            throw new PDOException("Error updating maintenance: " . $e->getMessage());
        }
    }
}