<?php

namespace src\app\models;

class User {
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUserByUsernameAndPassword(string $username, string $password) {
        $this->db->query("SELECT * FROM `checkride_user` WHERE CR_user = :username AND CR_password = :password");
        $this->db->bind(":username", $username);
        $this->db->bind(':password', hash('sha256', $password));
        return $this->db->single();
    }

    public function registerUser(string $username, string $password, string $email, string $status = 'user') {
        $this->db->query("INSERT INTO checkride_user (CR_user, CR_password, email, status) VALUES (:CR_user, :CR_password, :email, :statut)");
        $this->db->bind(":CR_user", $username);
        $this->db->bind(":CR_password", hash('sha256', $password));
        $this->db->bind(":email", $email);
        $this->db->bind(":statut", $status);
        return $this->db->execute();
    }

    public function getLastInsertId() {
        return $this->db->getLastInsertId();
    }
}