<?php

namespace app\models;

use PDO;

/**
 * PDO Database Class
 * Se connecte a la base de donnée
 * Prépare les query SQL
 * Bind les values
 *
 * @Author Azalphal
 */
class Database {
    private string $host = DB_HOST;
    private string $user = DB_USER;
    private string $pass = DB_PASS;
    private string $name = DB_NAME;

    private $db_handler;
    private $stmt;
    private $error;

    /**
     * Initialize une nouvelle connection a la base de donnée
     * a chaque fois qu'une nouvelle instance de la classe est initialisé
     */
    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->name;
        $options = [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,];

        // Create PDO Instance
        try {
            $this->db_handler = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * Prépare les requêtes sql
     *
     * @param $sql string Le contenu de la requête.
     * @return void
     */
    public function query($sql) {
        $this->stmt = $this->db_handler->prepare($sql);
    }

    /**
     * Bind les requêtes sql
     *
     * @param $param
     * @param $value
     * @param $type
     * @return void
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Execute une requête sql
     *
     * @return mixed
     */
    public function execute() {
        return $this->stmt->execute();
    }

    /**
     * Recupère le resultat en array
     *
     * @return mixed
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Recupère une seule entrée et la return en objet
     *
     * @return mixed
     */
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount() {
        return $this->stmt->rowCount();
    }
}