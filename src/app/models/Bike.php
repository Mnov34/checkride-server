<?php

namespace src\app\models;

// TODO: add real values in sql functions

class Bike {
    private $db;
    protected $id;
    protected $brand;
    protected $model;
    protected $cylinder;
    protected $prod_year; //Didnt you say delete this ?
    protected $plate;
    protected $acquisition_date; //same for this ?

    public function __construct() {
        $this->db = new Database;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getBrand() {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand): void {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getCylinder() {
        return $this->cylinder;
    }

    /**
     * @param mixed $cylinder
     */
    public function setCylinder($cylinder): void {
        $this->cylinder = $cylinder;
    }

    /**
     * @return mixed
     */
    public function getProdYear() {
        return $this->prod_year;
    }

    /**
     * @param mixed $prod_year
     */
    public function setProdYear($prod_year): void {
        $this->prod_year = $prod_year;
    }

    /**
     * @return mixed
     */
    public function getPlate() {
        return $this->plate;
    }

    /**
     * @param mixed $plate
     */
    public function setPlate($plate): void {
        $this->plate = $plate;
    }

    /**
     * @return mixed
     */
    public function getAcquisitionDate() {
        return $this->acquisition_date;
    }

    /**
     * @param mixed $acquisition_date
     */
    public function setAcquisitionDate($acquisition_date): void {
        $this->acquisition_date = $acquisition_date;
    }

    public function create() {
        $this->db->query("");
        $this->db->bind('', '');
        return (bool)$this->db->execute();
    }

    public function getBike($id) {
        return $this->db->query("");
    }

    public function getAllBikes(): array {
        $this->db->query("SELECT * FROM motorcycle");
        return $this->db->resultSet();
    }

    public function updateBike($id): bool {
        $this->db->query("");
        $this->db->bind('', '');
        return (bool)$this->db->execute();
    }

    public function deleteBike($id): bool {
        $this->db->query("");
        $this->db->bind('', '');
        return (bool)$this->db->execute();
    }

}