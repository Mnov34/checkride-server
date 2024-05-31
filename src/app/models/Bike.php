<?php

namespace src\app\models;

// TODO: add real values in sql functions

class Bike {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function saveBike() {
        $this->db->query("");
        $this->db->bind('', '');
        return (bool)$this->db->execute();
    }

    public function getBike($id) {
        return $this->db->query("");
    }

    public function getAllBikes(): array {
        $this->db->query("SELECT * FROM bikes");
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